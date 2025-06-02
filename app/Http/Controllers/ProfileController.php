<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    // Display the user's profile
    public function show()
    {
        $user = Auth::user(); // Get the currently authenticated user
        if (!$user) {
            Log::warning('Profile access attempted without authentication');
            return redirect()->route('login')->with('error', 'Please log in to view your profile.');
        }
        return view('profile.show', compact('user')); // Return the profile view with the user data
    }

    // Update the user's profile
    public function update(Request $request, $id)
    {
        try {
            $user = Auth::user();

            // Ensure the user is authorized
            if ($user->id != $id) {
                Log::warning('Unauthorized profile update attempt', ['user_id' => $user->id, 'attempted_id' => $id]);
                return redirect()->route('profile.show')->with('error', 'Unauthorized action.');
            }

            // Validate input (matching the form fields in profile.show)
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'gender' => 'nullable|string|in:male,female,other',
                'dob' => 'nullable|date|before:today',
                'mobile' => 'nullable|string|max:20',
                'marital_status' => 'nullable|string|in:single,married,divorced',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Prepare data for update
            $data = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'gender' => $validated['gender'],
                'dob' => $validated['dob'],
                'mobile' => $validated['mobile'],
                'marital_status' => $validated['marital_status'],
            ];

            // Update password if provided
            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            // Handle profile picture
            if ($request->hasFile('profile_picture')) {
                // Delete old picture if it exists
                if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                    Storage::delete('public/' . $user->profile_picture);
                }
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $data['profile_picture'] = $path;
            }

            // Update user
            $user->update($data);
            Log::info('Profile updated successfully', ['user_id' => $user->id]);

            return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            Log::error('Profile update failed', ['user_id' => $user->id, 'error' => $e->getMessage()]);
            return redirect()->route('profile.show')->with('error', 'Failed to update profile.');
        }
    }
}