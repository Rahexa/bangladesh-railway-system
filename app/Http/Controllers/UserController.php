<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function profile()
    {
        try {
            $user = Auth::user();
            Log::info('Profile accessed', ['user_id' => $user->id]);
            return view('profile', compact('user'));
        } catch (\Exception $e) {
            Log::error('Profile access failed', ['error' => $e->getMessage()]);
            return redirect()->route('dashboard')->with('error', 'Unable to load profile.');
        }
    }

    public function update(Request $request, $id)
    {
        // Implement update logic if needed in the future
        return redirect()->route('profile')->with('error', 'Update not implemented.');
    }
}