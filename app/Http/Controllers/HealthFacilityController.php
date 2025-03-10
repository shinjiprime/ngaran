<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\HealthFacility;
use App\Models\Barangay;
use App\Models\Municipality;
use App\Models\RHU;
use Illuminate\Http\Request;
use App\Models\Disease;
use App\Models\Patient;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

use Carbon\Carbon;

class HealthFacilityController extends Controller
{
    // Show profile for HF user
    public function showHfUser()
    {
        $staffId = Session::get('staff_id'); // Get the staff_id from session

        // Fetch staff with related health facility
        $staff = Staff::with('healthFacility')
            ->where('staff_id', $staffId)
            ->first();

        return view('hfpages.profile', compact('staff'));
    }

    // List all facilities
    public function index()
{
    // Fetch facilities with facility_type 3 or 4 and include the barangay relationship
    $facilities = HealthFacility::with('barangay')
        ->whereIn('facility_type', [3, 4])
        ->get();

    // Fetch related data
    $barangays = Barangay::all();
    $rhus = RHU::all();
    $municipalities = Municipality::all();

    return view('adminpages.healthfacilities', compact('facilities', 'barangays', 'rhus', 'municipalities'));
}

    // Load HF home
    public function loadHome()
    {$currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year; 

// Retrieve the rhu_id and health_facility from the session
$rhuId = session('rhu_id');
$facilityId = session('facility_id');  // Assuming facility_id is stored in session

// Count active cases (Morbidity)
$morbidityCount = Patient::where('status', 'active')
    ->whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->whereHas('staff', function($query) use ($rhuId, $facilityId) {
        $query->where('rhu_id', $rhuId)
              ->where('health_facility', $facilityId);  // Added condition for health_facility
    })
    ->count();

// Count deceased cases (Mortality)
$mortalityCount = Patient::where('status', 'deceased')
    ->whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->whereHas('staff', function($query) use ($rhuId, $facilityId) {
        $query->where('rhu_id', $rhuId)
              ->where('health_facility', $facilityId);  // Added condition for health_facility
    })
    ->count();

// Most infectious disease (highest count of active cases)
$mostInfectiousDisease = Patient::selectRaw('disease_code, COUNT(*) as count')
    ->where('status', 'active')
    ->whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->whereHas('staff', function($query) use ($rhuId, $facilityId) {
        $query->where('rhu_id', $rhuId)
              ->where('health_facility', $facilityId);  // Added condition for health_facility
    })
    ->groupBy('disease_code')
    ->orderBy('count', 'desc')
    ->first();

$mostInfectiousDiseaseName = $mostInfectiousDisease ? $mostInfectiousDisease->disease->disease_name : 'N/A';

// Most deadly disease (highest count of deceased cases)
$mostDeadlyDisease = Patient::selectRaw('disease_code, COUNT(*) as count')
    ->where('status', 'deceased')
    ->whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->whereHas('staff', function($query) use ($rhuId, $facilityId) {
        $query->where('rhu_id', $rhuId)
              ->where('health_facility', $facilityId);  // Added condition for health_facility
    })
    ->groupBy('disease_code')
    ->orderBy('count', 'desc')
    ->first();

$mostDeadlyDiseaseName = $mostDeadlyDisease ? $mostDeadlyDisease->disease->disease_name : 'N/A';

// Retrieve all municipalities
$municipalities = Municipality::all();

// Top infectious diseases
$topInfectiousDiseases = Patient::selectRaw('disease_code, COUNT(*) as count')
    ->where('status', 'active')
    ->whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->whereHas('staff', function($query) use ($rhuId, $facilityId) {
        $query->where('rhu_id', $rhuId)
              ->where('health_facility', $facilityId);  // Added condition for health_facility
    })
    ->groupBy('disease_code')
    ->orderBy('count', 'desc')
    ->with('disease')
    ->take(10)
    ->get();

// Top deadliest diseases
$topDeadliestDiseases = Patient::selectRaw('disease_code, COUNT(*) as count')
    ->where('status', 'deceased')
    ->whereMonth('date', $currentMonth)
    ->whereYear('date', $currentYear)
    ->whereHas('staff', function($query) use ($rhuId, $facilityId) {
        $query->where('rhu_id', $rhuId)
              ->where('health_facility', $facilityId);  // Added condition for health_facility
    })
    ->groupBy('disease_code')
    ->orderBy('count', 'desc')
    ->with('disease')
    ->take(10)
    ->get();

// Top deadly areas (municipalities with the highest deceased count)
$topDeadlyAreas = HealthFacility::whereIn('facility_type', [2, 3, 4])
    ->leftJoin('staff', 'health_facilities.facility_id', '=', 'staff.health_facility')
    ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
        $join->on('patients.staff_id', '=', 'staff.staff_id')
            ->whereMonth('patients.date', $currentMonth)
            ->whereYear('patients.date', $currentYear)
            ->where('patients.status', 'deceased');
    })
    ->where('health_facilities.rhu_id', session('rhu_id'))  // Add this line
    ->where('staff.health_facility', $facilityId)  // Added condition for health_facility
    ->select('health_facilities.facility_name', 'health_facilities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
    ->groupBy('health_facilities.facility_id', 'health_facilities.facility_name', 'health_facilities.coordinates')
    ->orderByDesc('patient_count')
    ->limit(10)
    ->get()
    ->map(function ($healthFacility) {
        return [
            'facility_name' => $healthFacility->facility_name,
            'coordinates' => $healthFacility->coordinates,
            'death_count' => $healthFacility->patient_count,
        ];
    });


        // Top sick areas (municipalities with the highest active case count)
        $topSickAreas = HealthFacility::whereIn('facility_type', [2, 3, 4])
        ->leftJoin('staff', 'health_facilities.facility_id', '=', 'staff.health_facility')
        ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
            $join->on('patients.staff_id', '=', 'staff.staff_id')
                ->whereMonth('patients.date', $currentMonth)
                ->whereYear('patients.date', $currentYear)
                ->where('patients.status', 'active');
        })
        ->where('health_facilities.rhu_id', session('rhu_id')) 
        ->select('health_facilities.facility_name', 'health_facilities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
        ->groupBy('health_facilities.facility_id', 'health_facilities.facility_name', 'health_facilities.coordinates')
        ->orderByDesc('patient_count')
        ->limit(10)
        ->get()
        ->map(function ($healthFacility) {
            return [
                'facility_name' => $healthFacility->facility_name,
                'coordinates' => $healthFacility->coordinates,
                'death_count' => $healthFacility->patient_count,
            ];
        });
    
    
        // Pass all data to the view
        return view('hfpages.home', compact(
            'municipalities',
            'morbidityCount',
            'mortalityCount',
            'mostInfectiousDiseaseName',
            'mostDeadlyDiseaseName',
            'topInfectiousDiseases', 'topDeadliestDiseases', 'topDeadlyAreas', 'topSickAreas'
        ));
        
        
    }

    // Create a new health facility
    public function create(Request $request)
    {
        
        $request->validate([
            'facility_name' => 'required|string|max:255',
            'facility_type' => 'required|integer|in:1,2,3,4',
            'barangay_id' => 'required', // Use barangay_id as foreign key
            'rhu_id' => 'required|integer',
            'coordinates' => 'required|string'
        ]);

        HealthFacility::create($request->all());
        return redirect()->back()->with('success', 'Health Facility added successfully.');
    }

    // Get data for editing a specific facility
    public function edit($id)
    {
        $facility = HealthFacility::with('barangay')->findOrFail($id); // Include barangay relationship
        return response()->json($facility);
    }

    // Update an existing health facility
    public function update(Request $request, $id)
    {
        $request->validate([
            'facility_name' => 'required|string|max:255',
            'facility_type' => 'required|integer|in:1,2,3,4',
            'barangay_id' => 'required|exists:barangays,id', // Use barangay_id as foreign key
            'rhu_id' => 'required|integer',
        ]);

        $facility = HealthFacility::findOrFail($id);
        $facility->update($request->all());

        return redirect()->route('health-facilities.index')->with('success', 'Health Facility updated successfully.');
    }

    // Delete a specific health facility
    public function destroy($id)
    {
        $facility = HealthFacility::findOrFail($id);
        $facility->delete();

        return redirect()->back()->with('success', 'Health Facility deleted successfully.');
    }
    public function getRhus($municipality_id)
{
    // Get the RHUs related to the municipality
    $rhus = RHU::where('municipality_id', $municipality_id)->get();

    return response()->json($rhus);
}
public function getBarangays($municipality_id)
    {
        
        
        $barangays = Barangay::where('municipality_id', $municipality_id)->get();

        return response()->json($barangays);
    }
public function getMunicipalityCoordinates($id)
{
    $municipality = Municipality::find($id);

    if ($municipality) {
        return response()->json(['coordinates' => $municipality->coordinates]);
    }

    return response()->json(['error' => 'Municipality not found'], 404);
}
public function updateLocation(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'id' => 'required', // Ensure the rhu_id exists in the database
            'coordinates' => 'required' // Ensure valid coordinates format
        ]);
    
        // Update the health facility where facility_type = 2 and rhu_id matches the provided ID
        $updatedRows = HealthFacility::where('facility_type', 2)
            ->where('rhu_id', $validated['id'])
            ->update(['coordinates' => $validated['coordinates']]);
    
        if ($updatedRows === 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'No health facility found with the specified criteria.'
            ], 404);
        }
    
        // Retrieve the updated health facility for the response
        $updatedFacility = HealthFacility::where('facility_type', 2)
            ->where('rhu_id', $validated['id'])
            ->first();
    
        return response()->json([
            'status' => 'success',
            'message' => 'Coordinates updated successfully!',
            'data' => $updatedFacility
        ]);
    }
    
public function updateLocation2(Request $request)
{
    // Validate the input
    $validated = $request->validate([
        'id' => 'required', // Ensure the rhu_id exists in the database
        'coordinates' => 'required' // Ensure valid coordinates format
    ]);

    // Update the health facility where facility_type = 2 and rhu_id matches the provided ID
    $updatedRows = HealthFacility::where('facility_type', 2)
        ->where('facility_id', $validated['id'])
        ->update(['coordinates' => $validated['coordinates']]);

    if ($updatedRows === 0) {
        return response()->json([
            'status' => 'error',
            'message' => 'No health facility found with the specified criteria.'
        ], 404);
    }

    // Retrieve the updated health facility for the response
    $updatedFacility = HealthFacility::where('facility_type', 2)
        ->where('facility_id', $validated['id'])
        ->first();

    return response()->json([
        'status' => 'success',
        'message' => 'Coordinates updated successfully!',
        'data' => $updatedFacility
    ]);
}

public function getfacs()
{

    $facilities = HealthFacility::with('barangay')->get(); // Include barangay relationship
         // Get barangay data for dropdowns
        return view('adminpages.partials.hf', compact('facilities'))->render();
   
}





}
