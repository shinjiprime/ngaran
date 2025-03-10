<?php

namespace App\Http\Controllers;

use App\Models\Disease; 
use App\Models\DiseaseGroup;// Import the Disease model
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DiseaseController extends Controller

{
    
    // Load all diseases to display in the view
   
    public function index()
{
    $diseases = Disease::all();
    $diseaseGroups = DiseaseGroup::all();  // Fetch all disease groups

    return view('adminpages.diseases', compact('diseases', 'diseaseGroups'));
}

    // Create a new disease record
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            
            'disease_name' => 'required|string|max:255',
            'icd10_code' => 'required|string|max:10',
            'disease_group_id' => 'required|string|max:255',
        ]);

        // Create a new Disease instance and save it
        Disease::create($validatedData);

        // Redirect the user after successful insertion
        return redirect()->back()->with('success', 'Disease record added successfully!');
    }

    // Update an existing disease record
    public function update(Request $request, $disease_code)
    {
        // Validate input data
        $validatedData = $request->validate([
            
            'disease_name' => 'required|string|max:255',
            'icd10_code' => 'required|string|max:10',
            'disease_group_id' => 'required|string|max:255',
        ]);

        // Find the disease record by code
        $disease = Disease::find($disease_code);
        if (!$disease) {
            return redirect()->back()->with('error', 'Disease not found');
        }

        // Update the disease record
        $disease->update($validatedData);

        return redirect()->back()->with('success', 'Disease record updated successfully');
    }

    // Delete a disease record
    public function destroy(Request $request, $disease_code)
    {
        $disease = Disease::find($disease_code);
        if ($disease) {
            $disease->delete();
            return redirect()->back()->with('success', 'Disease deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Disease not found');
        }
    }
    public function exportToExcel(Request $request)
{
    $data = $request->input('data');
    $type = $request->input('type');

    // Load the Excel template
    $templatePath = storage_path('app/templates/template.xlsx');
    $spreadsheet = IOFactory::load($templatePath);
    $sheet = $spreadsheet->getActiveSheet();

    // Set the report title based on the type
    if ($type === 'mortality') {
        $sheet->setCellValue('A8', 'Mortality Report');
    } else {
        $sheet->setCellValue('A8', 'Morbidity Report');
    }

    $sheet->setCellValue('G1', date('F')); // Full month name, e.g., January
    $sheet->setCellValue('G6', date('Y')); // Four-digit year, e.g., 2025

    // Specify the column mapping
    $columnMapping = [
        'A' => 0,  // Disease Name
        'B' => 1,  // Disease Code
        'C' => 2,  // 0-9 Male
        'D' => 3,  // 0-9 Female
        'E' => 4,  // 10-19 Male
        'F' => 5,  // 10-19 Female
        'G' => 6,  // 20-59 Male
        'H' => 7,  // 20-59 Female
        'I' => 8,  // 60+ Male
        'J' => 9,  // 60+ Female
        'K' => 10, // Total Male
        'M' => 11, // Total Female
        'O' => 12  // Total Male and Female
    ];

    // Start populating data at row 12
    $startRow = 12;
    foreach ($data as $rowIndex => $rowData) {
        foreach ($columnMapping as $columnLetter => $key) {
            $sheet->setCellValue("{$columnLetter}" . ($startRow + $rowIndex), $rowData[$key] ?? '');
        }
    }

    // Prepare the file for download
    $writer = new Xlsx($spreadsheet);
    $fileName = 'DiseaseData.xlsx';
    $tempFilePath = storage_path("app/public/{$fileName}");
    $writer->save($tempFilePath);

    // Return the file as a response
    return response()->download($tempFilePath)->deleteFileAfterSend(true);
}

    
}    