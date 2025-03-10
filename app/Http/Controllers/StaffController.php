<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Staff;
use App\Models\User; 

use App\Models\HealthFacility;

use App\Models\RHU;

use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Display a listing of the Staff
    public function index()
    {
        $staff = Staff::with('user')->get(); 
        $healthFacilities = HealthFacility::all(); // Fetch all HealthFacilities
    $rhus = RHU::all(); // Eager load the user relationship
        return view('adminpages.staff', compact('staff',  'healthFacilities', 'rhus'));
    }

    // Store a newly created Staff in storage
    public function create(Request $request)
    {
        // Validate the request
        $request->validate([
            'staff_fname' => 'required|string|max:255',
            'staff_mname' => 'nullable|string|max:255',
            'staff_lname' => 'required|string|max:255',
            'staff_extension' => 'nullable|string|max:10',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20', // Validate phone number
            'health_facility' => 'required|max:255',
            'rhu_id' => 'required|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:5',
            'user_level' => 'required|integer',
        ]);

        // Create the staff record
        $staff = Staff::create([
            'staff_fname' => $request->staff_fname,
            'staff_mname' => $request->staff_mname,
            'staff_lname' => $request->staff_lname,
            'staff_extension' => $request->staff_extension,
            'email' => $request->email,
            'phone_number' => $request->phone_number, // Add phone number
            'health_facility' => $request->health_facility,
            'rhu_id' => $request->rhu_id,
        ]);

        // Create the associated user account
        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'user_level' => $request->user_level,
            'staff_id' => $staff->staff_id,
            'email' => $request->email,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff and user account created successfully.');
    }

    // Update the specified Staff in storage
    public function update(Request $request, $staff_id)
    {
        $validator = Validator::make($request->all(), [
            'staff_fname' => 'required|string|max:255',
            'staff_mname' => 'nullable|string|max:255',
            'staff_lname' => 'required|string|max:255',
            'staff_extension' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:15', // Validate phone number
            'health_facility' => 'required|max:255',
            'rhu_id' => 'required|max:255',
            'username' => 'required|string|max:255',
            'user_level' => 'required|integer|min:1|max:4',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $staff = Staff::findOrFail($staff_id);
        $staff->update($request->only([
            'staff_fname', 'staff_mname', 'staff_lname', 
            'staff_extension', 'email', 'phone_number', // Include phone number
            'health_facility', 'rhu_id',
        ]));

        $user = $staff->user; // Assuming the staff has a user relation
        if ($user) {
            $user->update($request->only(['username', 'user_level']));
        }

        return redirect()->route('staff.index')->with('success', 'Staff updated successfully.');
    }

    // Remove the specified Staff from storage
    public function destroy($staff_id)
    {
        $staff = Staff::findOrFail($staff_id);

        // Delete the associated user through the relationship
        if ($staff->user) {
            $staff->user->delete();
        }

        // Delete the staff record
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff and associated user deleted successfully.');
    }

    // Change user password
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:5|confirmed',
        ]);

        // dd($request->all());

        $staff = User::findOrFail($id); // Assuming User is related to Staff
        // dd($staff->username);
        $staff->password = Hash::make($request->password);
        if ($staff->save()  ) {
            return redirect()->back()->with('success', 'Password changed successfully.');
        } else {
            return redirect()->back()->with('success', 'Password not changed.');
        }

        
    }
}
