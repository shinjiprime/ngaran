<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function loadLogin(){
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        $credentials = $request->only('username', 'password');
        Log::info($credentials);
        
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();

            Log::info($user->username);
        
            // Retrieve the staff details associated with the user
            $staff = $user->staff; // Assuming there's a relationship set up in the User model
    
            // Check if staff exists and retrieve the health facility name
            $healthFacilityName = $staff->healthFacility->facility_name ?? 'N/A';
    
            // Store staff details in the session
            session([
                'user_id' => $user->id,
                'staff_id' => $user->staff_id,
                'staff_fname' => $staff->staff_fname,
                'staff_lname' => $staff->staff_lname,
                'rhu_id' => $staff->rhu_id,
'facility_id' => $staff->healthFacility->facility_id,   

                'facility_name' => $healthFacilityName, // Store health facility name in session
            ]);
        
            // Redirect based on user_level
            switch ($user->user_level) {
                case 1:
                    return redirect('/admin');
                case 2:
                    return redirect('/phohome');
                case 3:
                    return redirect('/rhuhome');
                case 4:
                    return redirect('/hfhome');
                default:
                    return redirect('/loginpage')->withErrors(['user' => 'Unauthorized access.']);
            }
        } 
        
        return redirect('/loginpage')->withErrors(['credentials' => 'Invalid username or password.']);
    }
    
         public function logout(Request $request)
{
    // Forget staff-related session data
    $request->session()->forget(['user_id', 'staff_id', 'staff_fname', 'staff_lname', 'facility_name', 'rhu_id', 'facility_id']);

    // Log out the user
    Auth::logout();

    // Redirect to login page
    return redirect('/loginpage');
}

}
