<?php

namespace App\Http\Controllers;

use App\Models\User; // Make sure to import the User model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    // Display Users
    public function index()
    {
        $users = User::all(); // Retrieve all users
        return view('adminpages.users', compact('users')); // Adjust the view name as necessary
    }

    // Create User
    public function create(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'required|string', // Add validation for password
            'user_level' => 'required|integer',
            'staff_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new user
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password), // Hash the password before storing
            'user_level' => $request->user_level,
            'staff_id' => $request->staff_id,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Update User
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255',
            'password' => 'nullable|string', // Password is optional for update
            'user_level' => 'required|integer',
            'staff_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the user by ID and update their details
        $user = User::findOrFail($id);
        $user->username = $request->username;
        $user->user_level = $request->user_level;
        $user->staff_id = $request->staff_id;

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Hash the password before storing
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete User
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
    public function changePassword(Request $request)
    {
        // Validate the form inputs
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Get the logged-in user
        $user = User::find(Session::get('user_id'));

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }
}
