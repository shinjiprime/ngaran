<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use App\Models\Staff;
use App\Models\HealthFacility;
use App\Models\RHU;

class ProfileController extends Controller
{
    public function fetchProfile()
    {
        $staffId = Session::get('staff_id');

        $staff = Staff::with(['healthFacility', 'rhu'])
            ->where('staff_id', $staffId)
            ->first();

        if (!$staff) {
            return response()->json(['error' => 'Staff not found'], 404);
        }

        return response()->json([
            'full_name' => trim($staff->staff_fname . ' ' . $staff->staff_mname . ' ' . $staff->staff_lname . ' ' . $staff->staff_extension),
            'email' => $staff->email,
            'phone_number' => $staff->phone_number,
            'health_facility' => $staff->healthFacility->facility_name ?? 'N/A',
            'rhu_name' => $staff->rhu->municipality->municipality_name ?? 'N/A',
        ]);
    }
}

