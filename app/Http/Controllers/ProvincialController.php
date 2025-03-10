<?php

namespace App\Http\Controllers;


use App\Models\Disease;
use App\Models\Submission;
use App\Models\Patient;
use App\Models\Municipality;
use App\Models\RHU;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ProvincialController extends Controller
{
    
    public function loadHome() 
    {
        // Current month and year
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
    
        // Count active cases (Morbidity)
        $morbidityCount = Patient::where('status', 'active')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();
    
        // Count deceased cases (Mortality)
        $mortalityCount = Patient::where('status', 'deceased')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();
    
        // Most infectious disease (highest count of active cases)
        $mostInfectiousDisease = Patient::selectRaw('disease_code, COUNT(*) as count')
            ->where('status', 'active')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->groupBy('disease_code')
            ->orderBy('count', 'desc')
            ->first();
    
        $mostInfectiousDiseaseName = $mostInfectiousDisease ? $mostInfectiousDisease->disease->disease_name : 'N/A';
    
        // Most deadly disease (highest count of deceased cases)
        $mostDeadlyDisease = Patient::selectRaw('disease_code, COUNT(*) as count')
            ->where('status', 'deceased')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
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
            ->groupBy('disease_code')
            ->orderBy('count', 'desc')
            ->with('disease') // Assuming a relationship `disease` exists on the Patient model
            ->take(10)
            ->get();
    
        // Top deadliest diseases
        $topDeadliestDiseases = Patient::selectRaw('disease_code, COUNT(*) as count')
            ->where('status', 'deceased')
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->groupBy('disease_code')
            ->orderBy('count', 'desc')
            ->with('disease') // Assuming a relationship `disease` exists on the Patient model
            ->take(10)
            ->get();
    
        // Top deadly areas (municipalities with the highest deceased count)
        $topDeadlyAreas = Municipality::leftJoin('rhus', 'municipalities.id', '=', 'rhus.municipality_id')
            ->leftJoin('staff', 'rhus.rhu_id', '=', 'staff.rhu_id')
            ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
                $join->on('patients.staff_id', '=', 'staff.staff_id')
                     ->whereMonth('patients.date', $currentMonth)
                     ->whereYear('patients.date', $currentYear)
                     ->where('patients.status', 'deceased');
            })
            ->select('municipalities.municipality_name', 'municipalities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
            ->groupBy('municipalities.id', 'municipalities.municipality_name', 'municipalities.coordinates')
            ->orderByDesc('patient_count')  // Order by death count in descending order
            ->limit(10)  // Limit to top 10
            ->get()
            ->map(function ($municipality) {
                return [
                    'municipality_name' => $municipality->municipality_name,
                    'coordinates' => $municipality->coordinates,  // Adjust if coordinates are stored differently
                    'death_count' => $municipality->patient_count,
                ];
            });

            $topSickAreas = Municipality::leftJoin('rhus', 'municipalities.id', '=', 'rhus.municipality_id')
            ->leftJoin('staff', 'rhus.rhu_id', '=', 'staff.rhu_id')
            ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
                $join->on('patients.staff_id', '=', 'staff.staff_id')
                     ->whereMonth('patients.date', $currentMonth)
                     ->whereYear('patients.date', $currentYear)
                     ->where('patients.status', 'active');
            })
            ->select('municipalities.municipality_name', 'municipalities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
            ->groupBy('municipalities.id', 'municipalities.municipality_name', 'municipalities.coordinates')
            ->orderByDesc('patient_count')  // Order by death count in descending order
            ->limit(10)  // Limit to top 10
            ->get()
            ->map(function ($municipality) {
                return [
                    'municipality_name' => $municipality->municipality_name,
                    // Adjust if coordinates are stored differently
                    'death_count' => $municipality->patient_count,
                ];
            });
    
        // Pass all data to the view
        return view('phopages.home', compact(
            'municipalities',
            'morbidityCount',
            'mortalityCount',
            'mostInfectiousDiseaseName',
            'mostDeadlyDiseaseName',
            'topInfectiousDiseases', 'topDeadliestDiseases', 'topDeadlyAreas', 'topSickAreas'
        ));
    }
    

    
    public function morbidity(Request $request)
{
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
            $selectedAgeGroup // Pass age group to the function
        );
        $diseaseData[] = [
            'disease_name' => $disease->disease_name,
            'icd10_code' => $disease->icd10_code,
            'counts' => $counts,
        ];
    }

    if ($request->ajax()) {
        return view('phopages.partials.patients', compact('diseaseData'))->render();
    }

    return view('phopages.morbidity', compact('diseaseData', 'selectedYear', 'municipalities'));
}

public function mortality(Request $request)
{
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
            $selectedAgeGroup // Pass age group to the function
        );
        $diseaseData[] = [
            'disease_name' => $disease->disease_name,
            'icd10_code' => $disease->icd10_code,
            'counts' => $counts,
        ];
    }

    if ($request->ajax()) {
        return view('phopages.partials.patients', compact('diseaseData'))->render();
    }

    return view('phopages.mortality', compact('diseaseData', 'selectedYear', 'municipalities'));
}private function getDiseaseCounts($diseaseCode, $year, $month, $quarter, $gender, $status, $municipalityId, $selectedAgeGroup = null)
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
        $counts["{$selectedAgeGroup}_male"] = $this->getPatientCount($diseaseCode, $range, 'male', $year, $month, $quarter, $status, $municipalityId);
        $counts["{$selectedAgeGroup}_female"] = $this->getPatientCount($diseaseCode, $range, 'female', $year, $month, $quarter, $status, $municipalityId);
    } else {
        foreach ($ageGroups as $key => $range) {
            $counts["{$key}_male"] = $this->getPatientCount($diseaseCode, $range, 'male', $year, $month, $quarter, $status, $municipalityId);
            $counts["{$key}_female"] = $this->getPatientCount($diseaseCode, $range, 'female', $year, $month, $quarter, $status, $municipalityId);
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



private function getPatientCount($diseaseCode, $ageRange, $gender, $year, $month, $quarter, $status, $municipalityId)
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
        ->when($municipalityId, function ($query) use ($municipalityId) {
            $query->whereHas('staff', function ($query) use ($municipalityId) {
                $query->whereHas('rhu', function ($query) use ($municipalityId) {
                    $query->where('municipality_id', $municipalityId);
                });
            });
        })
        ->count();
}




public function showSubmissions()
{
    $currentMonth = Carbon::now()->month;

    // Fetch RHUs with submission counts and coordinates
    $rhus = RHU::with(['healthFacilities' => function ($query) {
        $query->where('facility_type', 2);
    }])->get();

    $rhuData = $rhus->map(function ($rhu) use ($currentMonth) {
        // Count submissions for the current month
        $submissionCount = Submission::whereHas('healthFacility', function ($query) use ($rhu) {
            $query->where('rhu_id', $rhu->rhu_id);
        })->whereMonth('date', $currentMonth)->count();

        // Assuming the healthFacilities relationship returns a collection, get the first one
        $healthFacility = $rhu->healthFacilities->first(); // Get the first matching facility
        $coordinates = $healthFacility ? $healthFacility->coordinates : null;

        return [
            'rhu_id' => $rhu->rhu_id,
            'rhu_name' => $rhu->rhu_name,
            'submission_count' => $submissionCount,
            'coordinates' => $coordinates,
            'status' => $submissionCount > 0 ? 'submitted' : 'not_submitted'
        ];
    });

    return view('phopages.submissions', compact('rhuData'));
}


public function getMorbidityMapData()
{
    $currentMonth = now()->month;
    $currentYear = now()->year;

    // Fetch all municipalities with patient counts
    $data = Municipality::leftJoin('rhus', 'municipalities.id', '=', 'rhus.municipality_id')
        ->leftJoin('staff', 'rhus.rhu_id', '=', 'staff.rhu_id')
        ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
            $join->on('patients.staff_id', '=', 'staff.staff_id')
                 ->whereMonth('patients.date', $currentMonth)
                 ->whereYear('patients.date', $currentYear)
                 ->where('patients.status', 'active');
        })
        ->select('municipalities.municipality_name', 'municipalities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
        ->groupBy('municipalities.id', 'municipalities.municipality_name', 'municipalities.coordinates')
        ->get()
        ->map(function ($municipality) {
            return [
                'municipality_name' => $municipality->municipality_name,
                'coordinates' => $municipality->coordinates,  // Adjust if coordinates are stored differently
                'patient_count' => $municipality->patient_count,
            ];
        });

    return response()->json($data);
}


public function getMortalityMapData()
{
    $currentMonth = now()->month;
    $currentYear = now()->year;

    // Fetch all municipalities with patient counts
    $data = Municipality::leftJoin('rhus', 'municipalities.id', '=', 'rhus.municipality_id')
        ->leftJoin('staff', 'rhus.rhu_id', '=', 'staff.rhu_id')
        ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
            $join->on('patients.staff_id', '=', 'staff.staff_id')
                 ->whereMonth('patients.date', $currentMonth)
                 ->whereYear('patients.date', $currentYear)
                 ->where('patients.status', 'deceased');
        })
        ->select('municipalities.municipality_name', 'municipalities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
        ->groupBy('municipalities.id', 'municipalities.municipality_name', 'municipalities.coordinates')
        ->get()
        ->map(function ($municipality) {
            return [
                'municipality_name' => $municipality->municipality_name,
                'coordinates' => $municipality->coordinates,  // Adjust if coordinates are stored differently
                'death_count' => $municipality->patient_count,
            ];
        });

    return response()->json($data);
}
public function generateReport1()
{
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    $topInfectiousDiseases = Patient::selectRaw('disease_code, COUNT(*) as count')
        ->where('status', 'active')
        ->whereMonth('date', $currentMonth)
        ->whereYear('date', $currentYear)
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
    ];

    // Load the Blade view as HTML
    $pdf = \PDF::loadView('reports.top_infectious_diseases_report1', $data);

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
    
        // Fetch data for the report
        $topInfectiousDiseases = Patient::selectRaw('disease_code, COUNT(*) as count')
            ->where('status', 'deceased')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', $currentYear)
            
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
        ];
    
        // Log the data being passed to the view
        Log::info('Data passed to the view:', $data);
    
        try {
            $pdf = \PDF::loadView('reports.top_infectious_diseases', $data)
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
        $currentYear = Carbon::now()->year;
    
        $topSickAreas = Municipality::leftJoin('rhus', 'municipalities.id', '=', 'rhus.municipality_id')
            ->leftJoin('staff', 'rhus.rhu_id', '=', 'staff.rhu_id')
            ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
                $join->on('patients.staff_id', '=', 'staff.staff_id')
                    ->whereMonth('patients.date', $currentMonth)
                    ->whereYear('patients.date', $currentYear)
                    ->where('patients.status', 'active');
            })
            ->select('municipalities.municipality_name', 'municipalities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
            ->groupBy('municipalities.id', 'municipalities.municipality_name', 'municipalities.coordinates')
            ->orderByDesc('patient_count')  // Order by patient count in descending order
            ->limit(10)  // Limit to top 10
            ->get()
            ->map(function ($municipality) {
                return [
                    'municipality_name' => $municipality->municipality_name,
                    'patient_count' => $municipality->patient_count,  // Corrected the key to 'patient_count'
                ];
            });
    
        // Pass data to the Blade view
        $data = [
            'topSickAreas' => $topSickAreas,
            'month' => Carbon::now()->format('F'),
            'year' => $currentYear,
        ];
    
        // Load the Blade view as HTML
        $pdf = \PDF::loadView('reports.top_sick_areas1', $data);
    
        // Set the filename and return the PDF as a download
        return $pdf->stream('Top_10_Highest_Morbidity_Report.pdf');
    }
    
    
    public function generateReport4()
{
    $currentMonth = Carbon::now()->month;
    $currentYear = Carbon::now()->year;

    $topSickAreas = Municipality::leftJoin('rhus', 'municipalities.id', '=', 'rhus.municipality_id')
        ->leftJoin('staff', 'rhus.rhu_id', '=', 'staff.rhu_id')
        ->leftJoin('patients', function ($join) use ($currentMonth, $currentYear) {
            $join->on('patients.staff_id', '=', 'staff.staff_id')
                ->whereMonth('patients.date', $currentMonth)
                ->whereYear('patients.date', $currentYear)
                ->where('patients.status', 'deceased');
        })
        ->select('municipalities.municipality_name', 'municipalities.coordinates', DB::raw('COUNT(patients.patients_id) as patient_count'))
        ->groupBy('municipalities.id', 'municipalities.municipality_name', 'municipalities.coordinates')
        ->orderByDesc('patient_count')  // Order by patient count in descending order
        ->limit(10)  // Limit to top 10
        ->get()
        ->map(function ($municipality) {
            return [
                'municipality_name' => $municipality->municipality_name,
                'patient_count' => $municipality->patient_count,  // Corrected the key to 'patient_count'
            ];
        });

    // Pass data to the Blade view
    $data = [
        'topSickAreas' => $topSickAreas,
        'month' => Carbon::now()->format('F'),
        'year' => $currentYear,
    ];

    // Load the Blade view as HTML
    $pdf = \PDF::loadView('reports.top_sick_areas', $data);

    // Set the filename and return the PDF as a download
    return $pdf->stream('Top_10_Highest_Mortality_Report.pdf');
}


}