
<?php
/*
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use Illuminate\Support\Facades\Auth;

class SslCommerzPaymentController extends Controller
{
    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'amount' => 'required|numeric',
            'name' => 'required|string',
            'contactNo' => 'required|string|max:15', // Ensure the field name matches the column
            'age' => 'required|integer',
            'sex' => 'required|in:male,female,other',
            'date' => 'required|date',
            'journeyType' => 'required|string',
            'class' => 'required|string',
            'ticketType' => 'required|string',
            'numberOfTickets' => 'required|integer',
        ]);

        // Fetch the logged-in user's email
        $user_email = Auth::user()->email;

        $post_data = array();
        $post_data['total_amount'] = $request->input('amount');
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // Generate a unique transaction ID

        // CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->input('name');
        $post_data['cus_phone'] = $request->input('contactNo');
        $post_data['cus_email'] = $user_email ?? 'not_provided@example.com'; // Provide a default value if email is empty

        // Provide default values for required fields
        $post_data['shipping_method'] = 'NO';
        $post_data['product_name'] = 'Ticket';
        $post_data['product_category'] = 'Travel';
        $post_data['product_profile'] = 'general';

        // Debugging: Check the contents of post_data
        \Log::info('Payment Data:', $post_data);

        // Insert initial booking data with Pending status
        DB::table('bookings')->insert([
            'transaction_id' => $post_data['tran_id'],
            'name' => $post_data['cus_name'],
            'contact_no' => $post_data['cus_phone'], // Ensure the field name matches
            'amount' => $post_data['total_amount'],
            'status' => 'Pending',
            'age' => $request->input('age'),
            'sex' => $request->input('sex'),
            'date' => $request->input('date'),
            'journeyType' => $request->input('journeyType'),
            'class' => $request->input('class'),
            'ticketType' => $request->input('ticketType'),
            'numberOfTickets' => $request->input('numberOfTickets'),
            'email' => $post_data['cus_email'],
        ]);

        // Before going to initiate the payment, order status needs to be updated as Pending.
        session(['transaction_id' => $post_data['tran_id']]);

        $sslc = new SslCommerzNotification();
        // Initiate the payment
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        // Check order status in the bookings table against the transaction id
        $order_details = DB::table('bookings')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details && $order_details->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                // Update booking information to Processing status
                DB::table('bookings')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Processing']);

                echo "<br>Transaction is successfully Completed";
            }
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is successfully Completed";
        } else {
            echo "Invalid Transaction";
        }
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('bookings')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details && $order_details->status == 'Pending') {
            DB::table('bookings')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Failed";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('bookings')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details && $order_details->status == 'Pending') {
            DB::table('bookings')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Canceled";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn(Request $request)
    {
        if ($request->input('tran_id')) {
            $tran_id = $request->input('tran_id');

            $order_details = DB::table('bookings')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details && $order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    DB::table('bookings')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
                echo "Transaction is already successfully Completed";
            } else {
                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}

*/