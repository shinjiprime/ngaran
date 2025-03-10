<?php

namespace App\Http\Controllers;

use App\Models\Disease;
use App\Models\Patient;
use App\Models\Municipality;
use App\Models\Submission;
use App\Models\HealthFacility;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\RHU;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class MunicipalityController extends Controller
{
    public function loadHome() {
        // Current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Retrieve the rhu_id from the session
        $rhuId = session('rhu_id');
    
        // Count active cases (Morbidity)
        $morbidityCount = Patient::where('status', 'active')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->whereHas('staff', function($query) use ($rhuId) {
                $query->where('rhu_id', $rhuId);
            })
            ->count();
    
        // Count deceased cases (Mortality)
        $mortalityCount = Patient::where('status', 'deceased')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->whereHas('staff', function($query) use ($rhuId) {
                $query->where('rhu_id', $rhuId);
            })
            ->count();
    
        // Most infectious disease (highest count of active cases)
        $mostInfectiousDisease = Patient::selectRaw('disease_code, COUNT(*) as count')
            ->where('status', 'active')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->whereHas('staff', function($query) use ($rhuId) {
                $query->where('rhu_id', $rhuId);
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
            ->whereHas('staff', function($query) use ($rhuId) {
                $query->where('rhu_id', $rhuId);
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
            ->whereHas('staff', function($query) use ($rhuId) {
                $query->where('rhu_id', $rhuId);
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
            ->whereHas('staff', function($query) use ($rhuId) {
                $query->where('rhu_id', $rhuId);
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
        ->where('health_facilities.rhu_id', session('rhu_id')) // Add this line
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
        return view('rhupages.home', compact(
            'municipalities',
            'morbidityCount',
            'mortalityCount',
            'mostInfectiousDiseaseName',
            'mostDeadlyDiseaseName',
            'topInfectiousDiseases', 'topDeadliestDiseases', 'topDeadlyAreas', 'topSickAreas'
        ));
        
    }
    public function morbidity2()
    {
        // Fetch the rhu_id from the session
        $sessionRhuId = session('rhu_id');

        // Retrieve staff_ids associated with the current session rhu_id
        $staffIds = Staff::where('rhu_id', $sessionRhuId)->pluck('staff_id')->toArray();

        // Fetch all diseases
        $diseases = Disease::all();

        $diseaseData = [];

        // Loop through each disease and get the patient counts for each age/gender group with status 'active'
        foreach ($diseases as $disease) {
            $counts = [
                'age_0_9_male' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [0, 9])
                    ->where('gender', 'male')
                    ->where('status', 'active') // Filter by status 'active'
                    ->whereIn('staff_id', $staffIds) 
                    ->count(),

                'age_0_9_female' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [0, 9])
                    ->where('gender', 'female')
                    ->where('status', 'active')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_10_19_male' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [10, 19])
                    ->where('gender', 'male')
                    ->where('status', 'active')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_10_19_female' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [10, 19])
                    ->where('gender', 'female')
                    ->where('status', 'active')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_20_59_male' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [20, 59])
                    ->where('gender', 'male')
                    ->where('status', 'active')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_20_59_female' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [20, 59])
                    ->where('gender', 'female')
                    ->where('status', 'active')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_60_above_male' => Patient::where('disease_code', $disease->disease_code)
                    ->where('age', '>=', 60)
                    ->where('gender', 'male')
                    ->where('status', 'active')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_60_above_female' => Patient::where('disease_code', $disease->disease_code)
                    ->where('age', '>=', 60)
                    ->where('gender', 'female')
                    ->where('status', 'active')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),
            ];

            // Store the disease and its counts in an array
            $diseaseData[] = [
                'disease_name' => $disease->disease_name,
                'disease_code' => $disease->disease_code,
                'counts' => $counts,
            ];
        }

        // Return the view and pass the disease data
        return view('rhupages.morbidity', compact('diseaseData'));
        }
        public function requests()
    {
        // Fetch the rhu_id from the session
        $sessionRhuId = session('rhu_id');

        // Retrieve staff_ids associated with the current session rhu_id
        $staffIds = Staff::where('rhu_id', $sessionRhuId)->pluck('staff_id')->toArray();

        // Fetch all diseases
        $diseases = Disease::all();

        $diseaseData = [];

        // Loop through each disease and get the patient counts for each age/gender group with status 'active'
        foreach ($diseases as $disease) {
            $counts = [
                'age_0_9_male' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [0, 9])
                    ->where('gender', 'male')
                    ->where('status', 'inactive') // Filter by status 'active'
                    ->whereIn('staff_id', $staffIds) 
                    ->count(),

                'age_0_9_female' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [0, 9])
                    ->where('gender', 'female')
                    ->where('status', 'inactive')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_10_19_male' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [10, 19])
                    ->where('gender', 'male')
                    ->where('status', 'inactive')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_10_19_female' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [10, 19])
                    ->where('gender', 'female')
                    ->where('status', 'inactive')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_20_59_male' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [20, 59])
                    ->where('gender', 'male')
                    ->where('status', 'inactive')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_20_59_female' => Patient::where('disease_code', $disease->disease_code)
                    ->whereBetween('age', [20, 59])
                    ->where('gender', 'female')
                    ->where('status', 'inactive')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_60_above_male' => Patient::where('disease_code', $disease->disease_code)
                    ->where('age', '>=', 60)
                    ->where('gender', 'male')
                    ->where('status', 'inactive')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),

                'age_60_above_female' => Patient::where('disease_code', $disease->disease_code)
                    ->where('age', '>=', 60)
                    ->where('gender', 'female')
                    ->where('status', 'inactive')
                    ->whereIn('staff_id', $staffIds)
                    ->count(),
            ];

            // Store the disease and its counts in an array
            $diseaseData[] = [
                'disease_name' => $disease->disease_name,
                'disease_code' => $disease->disease_code,
                'counts' => $counts,
            ];
        }

        // Return the view and pass the disease data
        return view('rhupages.morbidity', compact('diseaseData'));
        }
        public function mortalityex()
{
    // Fetch the rhu_id from the session
    $sessionRhuId = session('rhu_id');

    // Retrieve staff_ids associated with the current session rhu_id
    $staffIds = Staff::where('rhu_id', $sessionRhuId)->pluck('staff_id')->toArray();

    // Fetch all diseases
    $diseases = Disease::all();

    $diseaseData = [];

    // Loop through each disease and get the patient counts for each age/gender group with status 'deceased'
    foreach ($diseases as $disease) {
        $counts = [
            'age_0_9_male' => Patient::where('disease_code', $disease->disease_code)
                ->whereBetween('age', [0, 9])
                ->where('gender', 'male')
                ->where('status', 'deceased') // Changed to 'deceased'
                ->whereIn('staff_id', $staffIds) 
                ->count(),

            'age_0_9_female' => Patient::where('disease_code', $disease->disease_code)
                ->whereBetween('age', [0, 9])
                ->where('gender', 'female')
                ->where('status', 'deceased')
                ->whereIn('staff_id', $staffIds)
                ->count(),

            'age_10_19_male' => Patient::where('disease_code', $disease->disease_code)
                ->whereBetween('age', [10, 19])
                ->where('gender', 'male')
                ->where('status', 'deceased')
                ->whereIn('staff_id', $staffIds)
                ->count(),

            'age_10_19_female' => Patient::where('disease_code', $disease->disease_code)
                ->whereBetween('age', [10, 19])
                ->where('gender', 'female')
                ->where('status', 'deceased')
                ->whereIn('staff_id', $staffIds)
                ->count(),

            'age_20_59_male' => Patient::where('disease_code', $disease->disease_code)
                ->whereBetween('age', [20, 59])
                ->where('gender', 'male')
                ->where('status', 'deceased')
                ->whereIn('staff_id', $staffIds)
                ->count(),

            'age_20_59_female' => Patient::where('disease_code', $disease->disease_code)
                ->whereBetween('age', [20, 59])
                ->where('gender', 'female')
                ->where('status', 'deceased')
                ->whereIn('staff_id', $staffIds)
                ->count(),

            'age_60_above_male' => Patient::where('disease_code', $disease->disease_code)
                ->where('age', '>=', 60)
                ->where('gender', 'male')
                ->where('status', 'deceased')
                ->whereIn('staff_id', $staffIds)
                ->count(),

            'age_60_above_female' => Patient::where('disease_code', $disease->disease_code)
                ->where('age', '>=', 60)
                ->where('gender', 'female')
                ->where('status', 'deceased')
                ->whereIn('staff_id', $staffIds)
                ->count(),
        ];

        // Store the disease and its counts in an array
        $diseaseData[] = [
            'disease_name' => $disease->disease_name,
            'disease_code' => $disease->disease_code,
            'counts' => $counts,
        ];
    }

    // Return the view and pass the disease data
    return view('rhupages.morbidity', compact('diseaseData'));

    
}public function morbiditynow(Request $request)
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
        return view('rhupages.partials.patients', compact('patients'))->render();
    }

    return view('rhupages.consultations', compact('patients', 'diseases', 'selectedYear'));
}



public function morbidityall()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session
    $patients = Patient::where('staff_id', $staff_id)
                        ->where('status', 'active') 
                        ->with('disease') // Add condition for active status
                        ->get();
                        
    $diseases = Disease::all(); // Retrieve all diseases

    return view('rhupages.consultations', compact('patients', 'diseases'));
}

public function pending()
{
    $staff_id = session('staff_id'); // Retrieve staff_id from session
    $patients = Patient::
                        where('status', 'inactive') 
                        ->with('disease') // Add condition for active status
                        ->get();
                        
    $diseases = Disease::all(); // Retrieve all diseases

    return view('rhupages.pending', compact('patients', 'diseases'));
}
public function markAsDeceased($patientId)
    {
        $patient = Patient::findOrFail($patientId);
        $patient->status = 'deceased';
        $patient->save();

        return redirect()->back()->with('success', 'Patient status updated to deceased.');
    }

    public function showHfUser()
{
    $staffId = Session::get('staff_id'); // Get the staff_id from session

    // Fetch staff with related health facility
    $staff = Staff::with('healthFacility')
        ->where('staff_id', $staffId)
        ->first();

    return view('rhupages.profile', compact('staff'));
}

    
    public function morbidity(Request $request)
{
    $sessionRhuId = session('rhu_id');

            // Retrieve staff_ids associated with the current session rhu_id
    $staffIds = Staff::where('rhu_id', $sessionRhuId)->pluck('staff_id')->toArray();

    $selectedYear = $request->input('year', now()->year);
    $selectedMonth = $request->input('month');
    $selectedQuarter = $request->input('quarter');
    $selectedGender = $request->input('gender');
    $selectedStatus = 'active';
    $selectedMunicipality = $request->input('municipality_id');
    $selectedAgeGroup = $request->input('age_group');  // Get selected age group
    $municipalities = Municipality::all();

    $diseases = Disease::all();
    $diseaseData = [];

    foreach ($diseases as $disease) {
        $counts = $this->getDiseaseCounts(
            $disease->disease_code,
            $selectedYear,
            $selectedMonth,
            $selectedQuarter,
            $selectedGender,
            $selectedStatus,
            $selectedMunicipality,
            $selectedAgeGroup,
            $staffIds
              // Pass age group to the function
        );
        $diseaseData[] = [
            'disease_name' => $disease->disease_name,
            'icd10_code' => $disease->icd10_code,
            'counts' => $counts,
        ];
    }

    if ($request->ajax()) {
        return view('rhupages.partials.records', compact('diseaseData'))->render();
    }

    return view('rhupages.morbidity', compact('diseaseData', 'selectedYear', 'municipalities'));
}

public function mortality(Request $request)
{
    $sessionRhuId = session('rhu_id');

            // Retrieve staff_ids associated with the current session rhu_id
    $staffIds = Staff::where('rhu_id', $sessionRhuId)->pluck('staff_id')->toArray();

    $selectedYear = $request->input('year', now()->year);
    $selectedMonth = $request->input('month');
    $selectedQuarter = $request->input('quarter');
    $selectedGender = $request->input('gender');
    $selectedStatus = 'deceased';
    $selectedMunicipality = $request->input('municipality_id');
    $selectedAgeGroup = $request->input('age_group');  // Get selected age group
    $municipalities = Municipality::all();

    $diseases = Disease::all();
    $diseaseData = [];

    foreach ($diseases as $disease) {
        $counts = $this->getDiseaseCounts(
            $disease->disease_code,
            $selectedYear,
            $selectedMonth,
            $selectedQuarter,
            $selectedGender,
            $selectedStatus,
            $selectedMunicipality,
            $selectedAgeGroup,
            $staffIds
              // Pass age group to the function
        );
        $diseaseData[] = [
            'disease_name' => $disease->disease_name,
            'icd10_code' => $disease->icd10_code,
            'counts' => $counts,
        ];
    }

    if ($request->ajax()) {
        return view('rhupages.partials.records', compact('diseaseData'))->render();
    }

    return view('rhupages.mortality', compact('diseaseData', 'selectedYear', 'municipalities'));
}

    

    private function getDiseaseCounts($diseaseCode, $year, $month, $quarter, $gender, $status, $municipalityId, $selectedAgeGroup = null, $staffIds)
{
    $ageGroups = [
        'age_0_9' => [0, 9],
        'age_10_19' => [10, 19],
        'age_20_59' => [20, 59],
        'age_60_above' => [60, 200],
    ];

    $counts = [];

    // Initialize all keys with zero to avoid undefined array keys
    foreach ($ageGroups as $key => $range) {
        $counts["{$key}_male"] = 0;
        $counts["{$key}_female"] = 0;
    }

    $counts['age_all_male'] = 0;
    $counts['age_all_female'] = 0;
    $counts['age_total'] = 0;

    // Fetch data for selected age group or all age groups
    if ($selectedAgeGroup && isset($ageGroups[$selectedAgeGroup])) {
        $range = $ageGroups[$selectedAgeGroup];
        $counts["{$selectedAgeGroup}_male"] = $this->getPatientCount($diseaseCode, $range, 'male', $year, $month, $quarter, $status, $municipalityId,  $staffIds);
        $counts["{$selectedAgeGroup}_female"] = $this->getPatientCount($diseaseCode, $range, 'female', $year, $month, $quarter, $status, $municipalityId,  $staffIds);
    } else {
        foreach ($ageGroups as $key => $range) {
            $counts["{$key}_male"] = $this->getPatientCount($diseaseCode, $range, 'male', $year, $month, $quarter, $status, $municipalityId, $staffIds);
            $counts["{$key}_female"] = $this->getPatientCount($diseaseCode, $range, 'female', $year, $month, $quarter, $status, $municipalityId, $staffIds);
        }
    }

    // Calculate totals based on gender
    if ($gender === 'male') {
        $counts['age_total'] = array_sum(array_filter($counts, fn($key) => str_ends_with($key, '_male'), ARRAY_FILTER_USE_KEY));
    } elseif ($gender === 'female') {
        $counts['age_total'] = array_sum(array_filter($counts, fn($key) => str_ends_with($key, '_female'), ARRAY_FILTER_USE_KEY));
    } else {
        $counts['age_all_male'] = array_sum(array_filter($counts, fn($key) => str_ends_with($key, '_male'), ARRAY_FILTER_USE_KEY));
        $counts['age_all_female'] = array_sum(array_filter($counts, fn($key) => str_ends_with($key, '_female'), ARRAY_FILTER_USE_KEY));
        $counts['age_total'] = $counts['age_all_male'] + $counts['age_all_female'];
    }

    // Filter by gender by returning only relevant keys, but keep all initialized keys
    if ($gender) {
        foreach ($counts as $key => $value) {
            if (!str_contains($key, "_{$gender}") && $key !== 'age_total') {
                $counts[$key] = 0; // Reset to zero instead of removing the key
            }
        }
    }

    return $counts;
}



private function getPatientCount($diseaseCode, $ageRange, $gender, $year, $month, $quarter, $status, $municipalityId, $staffIds)
{
    return Patient::where('disease_code', $diseaseCode)
        ->when($ageRange, fn($query) => $query->whereBetween('age', $ageRange))
        ->when($gender, fn($query) => $query->where('gender', $gender))
        ->when($status, fn($query) => $query->where('status', $status))
        ->whereYear('date', $year)
        ->when($quarter, function ($query) use ($quarter) {
            $quarters = [
                'Q1' => [1, 3],
                'Q2' => [4, 6],
                'Q3' => [7, 9],
                'Q4' => [10, 12],
            ];
            $query->whereMonth('date', '>=', $quarters[$quarter][0])
                  ->whereMonth('date', '<=', $quarters[$quarter][1]);
        })
        ->when($month, fn($query) => $query->whereMonth('date', $month))
        ->whereIn('staff_id', $staffIds) 
        ->when($municipalityId, function ($query) use ($municipalityId) {
            $query->whereHas('staff', function ($query) use ($municipalityId) {
                $query->whereHas('rhu', function ($query) use ($municipalityId) {
                    $query->where('municipality_id', $municipalityId);
                });
            });
        })
        ->count();
}

        public function index()
        {
            $municipalities = Municipality::all(); // Fetch all Municipality records
            return view('adminpages.municipalities', compact('municipalities'));
        }
    
        // Create a new municipality record
        public function store(Request $request)
        {
            // Validate the incoming request
            $validatedData = $request->validate([
                'municipality_name' => 'required|string|max:255',
                'coordinates' => 'required|string',
            ]);
    
            // Create a new Municipality instance and save it
            Municipality::create($validatedData);
    
            // Redirect the user after successful insertion
            return redirect()->back()->with('success', 'Municipality added successfully!');
        }
    
        // Update an existing municipality record
        public function update(Request $request, $id)
        {
            // Validate input data
            $validatedData = $request->validate([
                'municipality_name' => 'required|string|max:255',
                'coordinates' => 'required|string',
            ]);
    
            // Find the municipality record by ID
            $municipality = Municipality::find($id);
            if (!$municipality) {
                return redirect()->back()->with('error', 'Municipality not found');
            }
    
            // Update the municipality record
            $municipality->update($validatedData);
    
            return redirect()->back()->with('success', 'Municipality updated successfully');
        }
    
        // Delete a municipality record
        public function destroy(Request $request, $id)
        {
            $municipality = Municipality::find($id);
            if ($municipality) {
                $municipality->delete();
                return redirect()->back()->with('success', 'Municipality deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Municipality not found');
            }
        }
        public function showSubmissions() 
{
    $currentMonth = Carbon::now()->month;

    // Fetch the current RHU ID from the session
    $sessionRhuId = session('rhu_id');

    // Fetch HealthFacilities with submission counts and coordinates
    $healthFacilities = HealthFacility::where('rhu_id', $sessionRhuId)
        ->whereIn('facility_type', [3, 4])
        ->get();

    $facilityData = $healthFacilities->map(function ($facility) use ($currentMonth) {
        // Count submissions for this HealthFacility
       

        $submissionCount = Submission::whereHas('healthFacility', function ($query) use ($facility) {
            $query->where('facility_id', $facility->facility_id);
        })->whereMonth('date', $currentMonth)->count();

        return [
            'facility_id' => $facility->facility_id,
            'facility_name' => $facility->facility_name,
            'submission_count' => $submissionCount,
            'coordinates' => $facility->coordinates,
            'status' => $submissionCount > 0 ? 'submitted' : 'not_submitted',
        ];
    });

    return view('rhupages.submissions', compact('facilityData'));
}

public function getMorbidityMapData()
{
    $currentMonth = now()->month;
    $currentYear = now()->year;

    // Fetch all municipalities with patient counts
    $data = HealthFacility::whereIn('facility_type', [2, 3, 4])
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
                'municipality_name' => $healthFacility->facility_name,
                'coordinates' => $healthFacility->coordinates,
                'patient_count' => $healthFacility->patient_count,
            ];
        });
    

    return response()->json($data);
}


public function getMortalityMapData()
{
    $currentMonth = now()->month;
    $currentYear = now()->year;

    // Fetch all municipalities with patient counts
    $data = HealthFacility::whereIn('facility_type', [2, 3, 4])
    ->leftJoin('staff', 'health_facilities.facility_id', '=', 'staff.health_facility')
    ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
        $join->on('patients.staff_id', '=', 'staff.staff_id')
            ->whereMonth('patients.date', $currentMonth)
            ->whereYear('patients.date', $currentYear)
            ->where('patients.status', 'deceased');
    })
    ->where('health_facilities.rhu_id', session('rhu_id')) 
    ->select('health_facilities.facility_name', 'health_facilities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
    ->groupBy('health_facilities.facility_id', 'health_facilities.facility_name', 'health_facilities.coordinates')
    ->orderByDesc('patient_count')
    ->limit(10)
    ->get()
    ->map(function ($healthFacility) {
        return [
            'municipality_name' => $healthFacility->facility_name,
            'coordinates' => $healthFacility->coordinates,
            'death_count' => $healthFacility->patient_count,
        ];
    });

    return response()->json($data);
}
    
    
public function generateReport1()
{
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;
    $rhuId = session('rhu_id');
    $rhuName = RHU::where('rhu_id', $rhuId)->value('rhu_name');

    $topInfectiousDiseases = Patient::selectRaw('disease_code, COUNT(*) as count')
        ->where('status', 'active')
        ->whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
        ->whereHas('staff', function($query) use ($rhuId) {
            $query->where('rhu_id', $rhuId);
        })
        ->groupBy('disease_code')
        ->orderBy('count', 'desc')
        ->with('disease') // Assuming a relationship `disease` exists on the Patient model
        ->take(10)
        ->get(); // Fetch your top diseases logic here

    // Prepare data for the view
    $data = [
        'topInfectiousDiseases' => $topInfectiousDiseases,
        'month' => Carbon::now()->format('F'),
        'year' => $currentYear,
        'rhuName' => $rhuName,
    ];

    // Load the Blade view as HTML
    $pdf = \PDF::loadView('reportsrhu.top_infectious_diseases_report1', $data);

    // Set the filename and return the PDF as a download
    return $pdf->stream('Top_10_Infectious_Diseases_Report.pdf');
}



    

    public function generateReport2() 
    {
        // Log start of report generation
        Log::info('Starting generateReport2 function');
    
        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->year;
        Log::info('Current Month and Year:', ['month' => $currentMonth, 'year' => $currentYear]);
    
        $rhuId = session('rhu_id');
        Log::info('RHU ID from session:', ['rhu_id' => $rhuId]);
        $rhuName = RHU::where('rhu_id', $rhuId)->value('rhu_name');
    
        // Fetch data for the report
        $topInfectiousDiseases = Patient::selectRaw('disease_code, COUNT(*) as count')
            ->where('status', 'deceased')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', $currentYear)
            ->whereHas('staff', function($query) use ($rhuId) {
                $query->where('rhu_id', $rhuId);
            })
            ->groupBy('disease_code')
            ->orderBy('count', 'desc')
            ->with('disease')
            ->take(10)
            ->get();
    
        // Log the retrieved data
        Log::info('Top Infectious Diseases Data:', ['data' => $topInfectiousDiseases]);
    
        $data = [
            'topInfectiousDiseases' => $topInfectiousDiseases,
            'month' => $currentMonth,
            'year' => $currentYear,
            'rhuName' => $rhuName,
        ];
    
        // Log the data being passed to the view
        Log::info('Data passed to the view:', $data);
    
        try {
            $pdf = \PDF::loadView('reportsrhu.top_infectious_diseases', $data)
                ->setPaper('a4', 'portrait');
            
            // Log successful PDF generation
            Log::info('PDF generated successfully');
        } catch (\Exception $e) {
            // Log any exceptions during PDF generation
            Log::error('Error generating PDF:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    
       return $pdf->stream('Top_10_Deadly_Diseases_Report.pdf');
    }
    
    
public function generateReport3()
{
    $currentMonth = Carbon::now()->month;
    $currentMonth2 = Carbon::now()->format('F');
    $currentYear = Carbon::now()->year;
    $rhuId = session('rhu_id');
    $rhuName = RHU::where('rhu_id', $rhuId)->value('rhu_name');

    $topSickAreas = HealthFacility::whereIn('facility_type', [2, 3, 4])
        ->leftJoin('staff', 'health_facilities.facility_id', '=', 'staff.health_facility')
        ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
            $join->on('patients.staff_id', '=', 'staff.staff_id')
                ->whereMonth('patients.date', $currentMonth)
                ->whereYear('patients.date', $currentYear)
                ->where('patients.status', 'active');
        })
        ->where('health_facilities.rhu_id', $rhuId)
        ->select('health_facilities.facility_name', 'health_facilities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
        ->groupBy('health_facilities.facility_id', 'health_facilities.facility_name', 'health_facilities.coordinates')
        ->orderByDesc('patient_count')
        ->limit(10)
        ->get();

    $pdf = \PDF::loadView('reportsrhu.top_sick_areas', compact('topSickAreas','currentMonth2', 'currentYear', 'rhuName'));
    return $pdf->stream('Top_10_Highest_Morbidity_Report.pdf');
}
    
       
public function generateReport4()
{
    $currentMonth = Carbon::now()->month;
    $currentMonth2 = Carbon::now()->format('F');
    $currentYear = Carbon::now()->year;
    $rhuId = session('rhu_id');
    $rhuName = RHU::where('rhu_id', $rhuId)->value('rhu_name');

    $topSickAreas = HealthFacility::whereIn('facility_type', [2, 3, 4])
        ->leftJoin('staff', 'health_facilities.facility_id', '=', 'staff.health_facility')
        ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
            $join->on('patients.staff_id', '=', 'staff.staff_id')
                ->whereMonth('patients.date', $currentMonth)
                ->whereYear('patients.date', $currentYear)
                ->where('patients.status', 'deceased');
        })
        ->where('health_facilities.rhu_id', $rhuId)
        ->select('health_facilities.facility_name', 'health_facilities.coordinates', DB::raw('COUNT(patients.patients_id) as death_count'))
        ->groupBy('health_facilities.facility_id', 'health_facilities.facility_name', 'health_facilities.coordinates')
        ->orderByDesc('death_count')
        ->limit(10)
        ->get();

    $pdf = \PDF::loadView('reportsrhu.top_sick_areas1', compact('topSickAreas','currentMonth2', 'currentYear', 'rhuName'));
    return $pdf->stream('Top_10_Highest_Mortality_Report.pdf');
}



    
    

    }
    
