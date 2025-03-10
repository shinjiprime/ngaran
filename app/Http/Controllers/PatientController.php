<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Disease; // Make sure to import your Patient model
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;


class PatientController extends Controller
{
    // Display a listing of the patients
    public function index()
    {
        $patients = Patient::all(); // Retrieve all patients
        return view('adminpages.patients', compact('patients')); // Return the view with patients data
    }

    public function index2()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session
    $patients = Patient::where('staff_id', $staff_id)->get(); 
    $diseases = Disease::all(); // Retrieve all diseases// Filter by staff_id

    return view('hfpages.patients', compact('patients', 'diseases'));


}public function morbidity2()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session

    // Get the current month and year
    $currentMonth = now()->month;
    $currentYear = now()->year;

    // Retrieve patient records where staff_id matches and date is in the current month
    $patients = Patient::where('staff_id', $staff_id)
        ->whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
        ->where('status', 'active') 
        ->get();

    $diseases = Disease::all(); // Retrieve all diseases

    return view('hfpages.consultations', compact('patients', 'diseases'));
}

public function morbiditynow(Request $request)
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session

    // Get the selected filters from the request
    $selectedYear = $request->input('year', now()->year);
    $selectedMonth = $request->input('month'); // Allow null for "All Months"
    $selectedQuarter = $request->input('quarter'); // Allow null for "All Quarters"
    $selectedGender = $request->input('gender'); // Allow null for "All Genders"
    $selectedStatus = $request->input('status'); // Allow null for "All Statuses"

    // Base query: Fetch patients for the selected year
    $patientsQuery = Patient::where('staff_id', $staff_id)
        ->whereYear('date', $selectedYear);

    // Apply quarter filter
    if (!empty($selectedQuarter)) {
        switch ($selectedQuarter) {
            case 'Q1':
                $patientsQuery->whereMonth('date', '>=', 1)->whereMonth('date', '<=', 3);
                break;
            case 'Q2':
                $patientsQuery->whereMonth('date', '>=', 4)->whereMonth('date', '<=', 6);
                break;
            case 'Q3':
                $patientsQuery->whereMonth('date', '>=', 7)->whereMonth('date', '<=', 9);
                break;
            case 'Q4':
                $patientsQuery->whereMonth('date', '>=', 10)->whereMonth('date', '<=', 12);
                break;
        }
    }

    // Apply month filter
    if (!empty($selectedMonth)) {
        $patientsQuery->whereMonth('date', $selectedMonth);
    }

    // Apply gender filter
    if (!empty($selectedGender)) {
        $patientsQuery->where('gender', $selectedGender);
    }

    // Apply status filter
    if (!empty($selectedStatus)) {
        $patientsQuery->where('status', $selectedStatus); // Assume "status" column holds values like "active" or "deceased"
    }

    // Retrieve filtered patient records
    $patients = $patientsQuery->get();

    $diseases = Disease::all(); // Retrieve all diseases

    // If the request is an AJAX request, return the patients table view only
    if ($request->ajax()) {
        return view('hfpages.partials.patients', compact('patients'))->render();
    }

    return view('hfpages.consultations', compact('patients', 'diseases', 'selectedYear'));
}

public function morbidity()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session
    $patients = Patient::where('staff_id', $staff_id)
                        ->where('status', 'active') 
                        ->with('disease') // Add condition for active status
                        ->get();
                        
    $diseases = Disease::all(); // Retrieve all diseases

    return view('hfpages.consultations', compact('patients', 'diseases'));
}

public function requests()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session
    $patients = Patient::where('staff_id', $staff_id)
                        ->where('status', 'inactive')
                        ->with('disease')  // Add condition for active status
                        ->get();
                        
    $diseases = Disease::all(); // Retrieve all diseases

    return view('hfpages.consultations2', compact('patients', 'diseases'));
}
public function mortality()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session
    
    // Retrieve deceased patients with their related disease
    $patients = Patient::where('staff_id', $staff_id)
    
                        ->where('status', 'deceased')
                        ->with('disease') // Eager load the related disease
                        ->get();
                        
    // Retrieve all diseases
    $diseases = Disease::all(); 

    // Return the view with both patients and diseases
    return view('hfpages.dead', compact('patients', 'diseases'));
}
public function mortalitynow()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session
    $currentMonth = now()->month;
    $currentYear = now()->year;
    // Retrieve deceased patients with their related disease
    $patients = Patient::where('staff_id', $staff_id)
    ->whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
                        ->where('status', 'deceased')
                        ->with('disease') // Eager load the related disease
                        ->get();
                        
    // Retrieve all diseases
    $diseases = Disease::all(); 

    // Return the view with both patients and diseases
    return view('hfpages.dead', compact('patients', 'diseases'));
}


    // Store a newly created patient in storage
    public function create(Request $request)
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session

    $request->validate([
        'patient_fname' => 'required|string|max:255',
        'patient_minitial' => 'nullable|string', // Optional middle initial
        'patient_lname' => 'required|string|max:255',
        'patient_extension' => 'nullable|string|max:10', // Optional extension (Jr., Sr., etc.)
        'disease_code' => 'required|integer', // Assuming disease_code is an integer
        'age' => 'required|integer',
        'age_unit' => 'required|string|max:10', // Assuming age unit is a string
        'gender' => 'required|string|max:10', // Assuming gender is a string
        'status' => 'required|string|max:20', // Assuming status is a string
    ]);

    // Create a new patient record with the current date and staff_id from session
    Patient::create([
        'patient_fname' => $request->patient_fname,
        'patient_minitial' => $request->patient_minitial,
        'patient_lname' => $request->patient_lname,
        'patient_extension' => $request->patient_extension,
        'disease_code' => $request->disease_code,
        'staff_id' => $staff_id, // Use staff_id from session
        'date' => now()->toDateString(), // Set the date to the current date
        'age' => $request->age,
        'age_unit' => $request->age_unit,
        'gender' => $request->gender,
        'status' => $request->status,
    ]);

    return back()->with('success', 'Patient created successfully.');
}


    // Update the specified patient in storage
    public function update(Request $request, $id)
{
    // Validate the input data
    
  
    $validatedData = $request->validate([
        'patient_fname' => 'nullable',
'patient_minitial' => 'nullable',
'patient_lname' => 'nullable',
'patient_extension' => 'nullable',
'disease_code' => 'nullable',
'staff_id' => 'nullable',
'date' => 'nullable',
'age' => 'nullable',
'age_unit' => 'nullable',
'gender' => 'nullable',
'status' => 'nullable',

    ]);

    // Find the patient by ID, using findOrFail to ensure the patient exists
    $patient = Patient::findOrFail($id);  // Will throw a ModelNotFoundException if not found

    // Log the validated data for debugging
    Log::debug('Validated Patient Update Data:', $validatedData);

    // Attempt to update the patient's details
    try {
        // Check if the request passed the validation
        $updated = $patient->update([
            'patient_fname' => $validatedData['patient_fname'],
            'patient_minitial' => $validatedData['patient_minitial'],
            'patient_lname' => $validatedData['patient_lname'],
            'patient_extension' => $validatedData['patient_extension'],
            'disease_code' => $validatedData['disease_code'] ?? null   ,
            'staff_id' => $validatedData['staff_id'],
            'date' => $validatedData['date'],
            'age' => $validatedData['age'],
            'age_unit' => $validatedData['age_unit'],
            'gender' => $validatedData['gender'],
            'status' => $validatedData['status'],
        ]);
        
        // If the update was successful, redirect with success message
        if ($updated) {
            return back()->with('success', 'Patient updated successfully.');
        } else {
            // If the update was unsuccessful, log and return error
            Log::error('Patient update failed.', ['patient_id' => $id]);
            return back()->withErrors(['error' => 'Failed to update patient.']);
        }
    } catch (\Exception $e) {
        // Catch any exception and log it
        Log::error('Error while updating patient:', ['error' => $e->getMessage(), 'patient_id' => $id]);
        return back()->withErrors(['error' => 'An error occurred while updating the patient.']);
    }
}




    // Remove the specified patient from storage
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id); // Find the patient by ID
        $patient->delete(); // Delete the patient record

        return back()->with('success', 'Patient deleted successfully.'); // Redirect with success message
    }
    public function getMorbidityMortalityData() 
    {
        // Start date 6 months ago from today, inclusive of the current month
        $startDate = Carbon::now()->subMonths(6)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth(); // Include the full current month
    
        $data = [
            'months' => [],
            'morbidity' => [],
            'mortality' => []
        ];
    
        $currentDate = $startDate->copy();
        $monthCount = 0;
    
        // Loop to collect exactly 7 months of data (6 months back + current month)
        while ($monthCount < 7) {
            // Format the month with the year, e.g., "January 2025"
            $month = $currentDate->format('F Y');
            $data['months'][] = $month;
    
            // Get the exact start and end dates for the month
            $startOfMonth = $currentDate->copy()->startOfMonth(); // First day of the month at midnight
            $endOfMonth = $currentDate->copy()->endOfMonth()->setTime(23, 59, 59); // Last moment of the last day
    
            // Log the exact date range being used for debugging
            \Log::info("Fetching data for month: $month", [
                'start' => $startOfMonth,
                'end' => $endOfMonth
            ]);
    
            // Calculate morbidity count for the current month
            $morbidityCount = Patient::where('status', 'active')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();
    
            // Calculate mortality count for the current month
            $mortalityCount = Patient::where('status', 'deceased')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->count();
    
            // Log the counts for debugging
            \Log::info("Morbidity count: $morbidityCount, Mortality count: $mortalityCount");
    
            $data['morbidity'][] = $morbidityCount;
            $data['mortality'][] = $mortalityCount;
    
            // Manually increment to the next month (avoids issues with addMonth())
            $currentDate->modify('first day of next month');
            $monthCount++; // Ensure we are collecting exactly 7 months
        }
    
        return response()->json($data);
    }
}    