<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('initiatePayment');
    }

    public function initiatePayment(Request $request)
    {
        Log::info('Initiate payment request:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'payment_method' => 'required|in:SSLCOMMERZ,COD',
            'order_id' => 'nullable|integer|exists:orders,id',
            'card_type' => 'nullable|string|max:50', // Optional card_type
        ]);

        $userId = Auth::id();
        $orderId = $request->input('order_id');
        $paymentMethod = $request->input('payment_method');
        $cardType = $request->input('card_type'); // From form, if provided

        Log::info('Card type from request:', ['card_type' => $cardType]);

        return DB::transaction(function () use ($request, $userId, $orderId, $paymentMethod, $cardType) {
            $cartItems = Cart::where('user_id', $userId)->with('product')->get();

            Log::info('Cart items for order:', ['user_id' => $userId, 'cartItems' => $cartItems->toArray()]);

            if ($cartItems->isEmpty()) {
                Log::error('Cart is empty', ['user_id' => $userId]);
                return response()->json(['success' => false, 'message' => 'Cart is empty'], 422);
            }

            $totalAmount = 0;
            $validCartItems = [];

            foreach ($cartItems as $item) {
                if (!$item->product || !isset($item->quantity) || $item->quantity <= 0 || !$item->product_id) {
                    Log::warning('Invalid cart item skipped', [
                        'cart_id' => $item->id,
                        'product_id' => $item->product_id,
                        'product_exists' => $item->product ? 'yes' : 'no',
                        'quantity' => $item->quantity ?? 'null',
                    ]);
                    continue;
                }

                $price = $item->product->price ?? 0;
                $quantity = $item->quantity;
                $totalAmount += $price * $quantity;
                $validCartItems[] = $item;
            }

            if ($totalAmount <= 0 || empty($validCartItems)) {
                Log::error('No valid cart items or zero total', ['totalAmount' => $totalAmount]);
                return response()->json(['success' => false, 'message' => 'No valid cart items or invalid total amount'], 422);
            }

            $tranId = 'SSLCZ_ORDER_' . uniqid();
            $order = null;

            try {
                if ($orderId) {
                    $order = Order::where('id', $orderId)
                        ->where('user_id', $userId)
                        ->where('payment_status', 'pending')
                        ->first();

                    if (!$order) {
                        Log::error('Order not found or not eligible', ['order_id' => $orderId, 'user_id' => $userId]);
                        return response()->json(['success' => false, 'message' => 'Order not found or already processed'], 404);
                    }

                    $order->update([
                        'name' => $request->input('name'),
                        'rec_address' => $request->input('address'),
                        'phone' => $request->input('phone'),
                        'total_amount' => number_format($totalAmount, 2, '.', ''),
                        'transaction_id' => $tranId,
                        'payment_method' => $paymentMethod,
                        'card_type' => $paymentMethod === 'SSLCOMMERZ' ? ($cardType ?: null) : null,
                    ]);
                } else {
                    $order = Order::create([
                        'user_id' => $userId,
                        'name' => $request->input('name'),
                        'rec_address' => $request->input('address'),
                        'phone' => $request->input('phone'),
                        'total_amount' => number_format($totalAmount, 2, '.', ''),
                        'payment_status' => 'pending',
                        'status' => 'pending',
                        'transaction_id' => $tranId,
                        'payment_method' => $paymentMethod,
                        'card_type' => $paymentMethod === 'SSLCOMMERZ' ? ($cardType ?: null) : null,
                    ]);
                }

                Log::info('Order saved with card_type:', ['order_id' => $order->id, 'card_type' => $order->card_type]);
            } catch (\Exception $e) {
                Log::error('Failed to save order', ['error' => $e->getMessage(), 'order_id' => $orderId]);
                throw $e;
            }

            OrderItem::where('order_id', $order->id)->delete();
            foreach ($validCartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price ?? 0,
                ]);
                Log::info('OrderItem created:', [
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                    'card_type' => $cardType,
                ]);
            }

            if ($paymentMethod === 'COD') {
                $order->update([
                    'payment_status' => 'pending',
                    'status' => 'confirmed',
                ]);
                Cart::where('user_id', $userId)->delete();
                return response()->json([
                    'success' => true,
                    'url' => route('confirmation', [
                        'tranId' => $tranId,
                        'total_amount' => $order->total_amount,
                        'status' => 'success',
                        'payment_method' => 'Cash on Delivery',
                    ]),
                ]);
            }

            $post_data = [
                'store_id' => env('SSLCZ_STORE_ID'),
                'store_passwd' => env('SSLCZ_STORE_PASSWORD'),
                'total_amount' => number_format($totalAmount, 2, '.', ''),
                'currency' => 'BDT',
                'tran_id' => $tranId,
                'success_url' => url('/api/payment/success/' . $tranId),
                'fail_url' => url('/api/payment/fail'),
                'cancel_url' => url('/api/payment/cancel'),
                'ipn_url' => url('/api/payment/ipn'),
                'cus_name' => $request->input('name'),
                'cus_email' => Auth::user()->email ?? 'customer@example.com',
                'cus_add1' => $request->input('address'),
                'cus_city' => 'Dhaka',
                'cus_postcode' => '1000',
                'cus_country' => 'Bangladesh',
                'cus_phone' => $request->input('phone'),
                'product_name' => 'E-commerce Order',
                'product_category' => 'Retail',
                'product_profile' => 'general',
            ];

            $direct_api_url = env('SSLCZ_TEST_MODE', true)
                ? "https://sandbox.sslcommerz.com/gwprocess/v3/api.php"
                : "https://securepay.sslcommerz.com/gwprocess/v3/api.php";

            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $direct_api_url);
            curl_setopt($handle, CURLOPT_TIMEOUT, 30);
            curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($handle, CURLOPT_POST, 1);
            curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($post_data));
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

            $content = curl_exec($handle);
            $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

            if ($code == 200 && !curl_errno($handle)) {
                $sslcommerzResponse = json_decode($content, true);
                Log::info('SSLCOMMERZ Response:', $sslcommerzResponse);

                if (isset($sslcommerzResponse['GatewayPageURL']) && $sslcommerzResponse['GatewayPageURL'] != "") {
                    $order->update(['session_key' => $sslcommerzResponse['sessionkey']]);
                    return response()->json(['success' => true, 'url' => $sslcommerzResponse['GatewayPageURL']]);
                } else {
                    Log::error('GatewayPageURL missing', ['response' => $sslcommerzResponse]);
                    return response()->json(['success' => false, 'message' => 'GatewayPageURL missing!'], 404);
                }
            } else {
                Log::error('SSLCOMMERZ API failed', ['error' => curl_error($handle), 'code' => $code]);
                curl_close($handle);
                return response()->json(['success' => false, 'message' => 'Failed to connect with SSLCOMMERZ API'], 500);
            }
        });
    }

    public function success(Request $request, $tranId)
    {
        Log::info('Success callback triggered:', ['tranId' => $tranId, 'request_data' => $request->all()]);

        $order = Order::where('transaction_id', $tranId)->firstOrFail();

        if ($request->input('status') !== 'VALID') {
            Log::warning('Invalid payment status', ['tranId' => $tranId, 'status' => $request->input('status')]);
            return redirect()->route('mycart')->with('error', 'Invalid payment status.');
        }

        $paymentData = [
            'payment_status' => 'confirmed',
            'status' => 'confirmed',
            'bank_tran_id' => $request->input('bank_tran_id'),
            'card_type' => $request->input('card_type'),
            'gateway_response' => json_encode($request->all()),
        ];

        try {
            $order->update(array_filter($paymentData));
            Log::info('Order updated with payment data:', ['order_id' => $order->id, 'payment_data' => $paymentData]);
        } catch (\Exception $e) {
            Log::error('Failed to update order:', ['tranId' => $tranId, 'error' => $e->getMessage()]);
            return redirect()->route('mycart')->with('error', 'Failed to update order.');
        }

        Cart::where('user_id', $order->user_id)->delete();

        return redirect()->route('confirmation', [
            'tranId' => $tranId,
            'total_amount' => $order->total_amount,
            'status' => 'success',
            'card_type' => $paymentData['card_type'] ?: 'N/A',
            'payment_method' => $order->payment_method,
        ]);
    }

    public function fail(Request $request)
    {
        $tranId = $request->input('tran_id');
        Log::info('Payment failure callback:', ['tranId' => $tranId, 'request_data' => $request->all()]);

        if ($tranId) {
            $order = Order::where('transaction_id', $tranId)->first();
            if ($order) {
                $paymentData = [
                    'payment_status' => 'failed',
                    'status' => 'failed',
                    'bank_tran_id' => $request->input('bank_tran_id'),
                    'card_type' => $request->input('card_type'),
                    'gateway_response' => json_encode($request->all()),
                ];
                try {
                    $order->update(array_filter($paymentData));
                    Log::info('Order updated with failure data:', ['tranId' => $tranId, 'payment_data' => $paymentData]);
                } catch (\Exception $e) {
                    Log::error('Failed to update order on fail:', ['tranId' => $tranId, 'error' => $e->getMessage()]);
                }
            }
            return redirect()->route('mycart')->with('error', 'Payment failed.');
        }
        return redirect()->route('mycart')->with('error', 'Payment failed.');
    }

    public function cancel(Request $request)
    {
        $tranId = $request->input('tran_id');
        Log::info('Payment cancellation callback:', ['tranId' => $tranId, 'request_data' => $request->all()]);

        if ($tranId) {
            $order = Order::where('transaction_id', $tranId)->first();
            if ($order) {
                $paymentData = [
                    'payment_status' => 'cancelled',
                    'status' => 'cancelled',
                    'bank_tran_id' => $request->input('bank_tran_id'),
                    'card_type' => $request->input('card_type'),
                    'gateway_response' => json_encode($request->all()),
                ];
                try {
                    $order->update(array_filter($paymentData));
                    Log::info('Order updated with cancellation data:', ['tranId' => $tranId, 'payment_data' => $paymentData]);
                } catch (\Exception $e) {
                    Log::error('Failed to update order on cancel:', ['tranId' => $tranId, 'error' => $e->getMessage()]);
                }
            }
            return redirect()->route('mycart')->with('error', 'Payment cancelled.');
        }
        return redirect()->route('mycart')->with('error', 'Payment cancelled.');
    }

    public function ipn(Request $request)
    {
        Log::info('IPN received:', $request->all());
        $tranId = $request->input('tran_id');

        if (!$tranId) {
            Log::error('IPN missing tran_id', $request->all());
            return response()->json(['status' => 'error', 'message' => 'Transaction ID missing'], 400);
        }

        $order = Order::where('transaction_id', $tranId)->first();
        if (!$order) {
            Log::error('Order not found for IPN', ['tranId' => $tranId]);
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        $paymentStatus = $request->input('status') === 'VALID' ? 'confirmed' : 'pending';
        $paymentData = [
            'payment_status' => $paymentStatus,
            'status' => $paymentStatus,
            'bank_tran_id' => $request->input('bank_tran_id'),
            'card_type' => $request->input('card_type'),
            'gateway_response' => json_encode($request->all()),
        ];

        try {
            $order->update(array_filter($paymentData));
            Log::info('Order updated via IPN:', ['order_id' => $order->id, 'payment_data' => $paymentData]);
        } catch (\Exception $e) {
            Log::error('Failed to update order in IPN:', ['tranId' => $tranId, 'error' => $e->getMessage()]);
        }

        if ($paymentStatus === 'confirmed') {
            Cart::where('user_id', $order->user_id)->delete();
        }

        return response()->json(['status' => 'success']);
    }
}