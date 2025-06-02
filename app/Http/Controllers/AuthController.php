<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        Log::info('Showing registration form');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::info('Register method called', ['input' => $request->except('password', 'password_confirmation')]);

        try {
            $validated = $request->validate([
                'first_name' => 'required|string|min:2|max:255',
                'last_name' => 'required|string|min:2|max:255',
                'email' => 'required|email|unique:users,email|max:255',
                'password' => 'required|string|min:8|confirmed',
                'gender' => 'required|string|in:male,female,other',
                'dob' => 'required|date|before:today',
                'mobile' => 'required|string|min:10|max:15',
                'marital_status' => 'required|string|in:single,married,divorced,widowed',
            ]);

            Log::info('Validation passed', ['validated' => $validated]);

            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->password = $request->password; // Plain text as per requirement
            $user->gender = $request->gender;
            $user->dob = $request->dob;
            $user->mobile = $request->mobile;
            $user->marital_status = $request->marital_status;
            $user->save();

            Log::info('User saved', ['user_id' => $user->id]);

            return redirect()->route('login')->with('success', 'Account created successfully! Please log in.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Registration failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Registration failed. Please try again.')->withInput();
        }
    }

    public function showLoginForm()
    {
        Log::info('Showing login form');
        return view('auth.login');
    }

    public function login(Request $request)
    {
        Log::info('Login attempt', ['email' => $request->email]);

        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            Log::info('Login successful', ['user_id' => $user->id]);
            return redirect()->intended('dashboard')->with('success', 'Logged in successfully!');
        }

        Log::warning('Login failed', ['email' => $request->email]);
        return redirect()->back()->with('error', 'Invalid email or password.')->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Log::info('Logout', ['user_id' => Auth::id()]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }

    public function logoutAll(Request $request)
    {
        Log::info('Logout all sessions', ['user_id' => Auth::id()]);

        try {
            DB::table('sessions')
                ->where('user_id', Auth::id())
                ->delete();

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('All sessions logged out', ['user_id' => Auth::id()]);
            return redirect()->route('login')->with('success', 'Logged out from all devices successfully!');
        } catch (\Exception $e) {
            Log::error('Logout all failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->route('login')->with('error', 'Failed to log out from all devices. Please try again.');
        }
    }

    public function showForgotPasswordForm()
    {
        Log::info('Showing forgot password form');
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        Log::info('Forgot password: Send reset code attempt', ['email' => $request->email]);
    
        try {
            $validated = $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);
    
            // Generate a 6-digit numerical code
            $code = mt_rand(100000, 999999);
    
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $code,
                    'created_at' => Carbon::now()
                ]
            );
    
            // Use the ResetCodeMail Mailable class
            Mail::to($request->email)->send(new \App\Mail\ResetCodeMail($code));
    
            Log::info('Reset code emailed', ['email' => $request->email, 'code' => $code]);
            return redirect()->route('forgot-password.verify', ['email' => $request->email])
                             ->with('status', 'We have emailed your 6-digit password reset code!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Forgot password: Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Forgot password: Failed to send email', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to send reset email. Please try again.')->withInput();
        }
    }
    public function showVerifyCodeForm()
    {
        Log::info('Showing verify code form');
        return view('auth.verify-code');
    }

    public function verifyResetCode(Request $request)
    {
        Log::info('Forgot password: Verify reset code attempt', ['code' => $request->code, 'email' => $request->email]);
    
        try {
            $validated = $request->validate([
                'email' => 'required|email|exists:users,email',
                'code' => 'required|string|digits:6',
            ]);
    
            $reset = DB::table('password_resets')
                ->where('email', $request->email)
                ->where('token', $request->code)
                ->where('created_at', '>=', Carbon::now()->subMinutes(10))
                ->first();
    
            if (!$reset) {
                Log::warning('Forgot password: Invalid or expired code', ['code' => $request->code, 'email' => $request->email]);
                return redirect()->back()
                    ->with('error', 'Invalid or expired reset code.')
                    ->withInput();
            }
    
            Log::info('Forgot password: Reset code verified', ['email' => $reset->email]);
            return redirect()->route('password.reset', ['email' => $reset->email])
                ->with('status', 'Code verified! Please reset your password.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Forgot password: Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Forgot password: Verification failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Failed to verify code. Please try again.')->withInput();
        }
    }
    public function showResetPasswordForm($email)
    {
        Log::info('Showing reset password form', ['email' => $email]);

        $reset = DB::table('password_resets')->where('email', $email)->first();
        if (!$reset) {
            Log::warning('Invalid reset email', ['email' => $email]);
            return redirect()->route('forgot-password')->with('error', 'Invalid password reset request.');
        }

        return view('auth.reset-password', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        Log::info('Reset password attempt', ['email' => $request->email]);

        try {
            $validated = $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $reset = DB::table('password_resets')->where('email', $request->email)->first();
            if (!$reset) {
                Log::warning('Invalid reset email', ['email' => $request->email]);
                return $request->expectsJson()
                    ? response()->json(['error' => 'Invalid password reset request.'], 422)
                    : redirect()->route('forgot-password')->with('error', 'Invalid password reset request.');
            }

            $user = User::where('email', $request->email)->first();
            $user->password = $request->password; // Plain text as per requirement
            $user->save();

            DB::table('password_resets')->where('email', $request->email)->delete();

            Log::info('Password reset successful', ['email' => $request->email]);
            return $request->expectsJson()
                ? response()->json(['success' => true, 'redirect' => route('login')])
                : redirect()->route('login')->with('success', 'Password reset successfully! Please log in.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Reset password: Validation failed', ['errors' => $e->errors()]);
            return $request->expectsJson()
                ? response()->json(['error' => implode('<br>', $e->errors())], 422)
                : redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Reset password: Failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return $request->expectsJson()
                ? response()->json(['error' => 'Failed to reset password. Please try again.'], 422)
                : redirect()->back()->with('error', 'Failed to reset password. Please try again.')->withInput();
        }
    }
}