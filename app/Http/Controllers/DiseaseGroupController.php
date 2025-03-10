<?php

namespace App\Http\Controllers;
use App\Models\DiseaseGroup;
use Illuminate\Http\Request;

class DiseaseGroupController extends Controller
{
    // Load all disease groups to display in the view
public function index()
{
    $disease_groups = DiseaseGroup::all(); // Fetch all DiseaseGroup records
    return view('adminpages.diseaseGroups',compact('disease_groups'));
}
// Create a new disease group record
public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'disease_group_name' => 'required|string|max:255',
    ]);

    // Create a new DiseaseGroup instance and save it
    DiseaseGroup::create($validatedData);

    // Redirect the user after successful insertion
    return redirect()->back()->with('success', 'Disease group added successfully!');
}

// Update an existing disease group record
public function update(Request $request, $id)
{
    // Validate input data
    $validatedData = $request->validate([
        'disease_group_name' => 'required|string|max:255',
    ]);

    // Find the disease group record by ID
    $diseaseGroup = DiseaseGroup::find($id);
    if (!$diseaseGroup) {
        return redirect()->back()->with('error', 'Disease group not found');
    }

    // Update the disease group record
    $diseaseGroup->update($validatedData);

    return redirect()->back()->with('success', 'Disease group updated successfully');
}

// Delete a disease group record
public function destroy(Request $request, $id)
{
    $diseaseGroup = DiseaseGroup::find($id);
    if ($diseaseGroup) {
        $diseaseGroup->delete();
        return redirect()->back()->with('success', 'Disease group deleted successfully');
    } else {
        return redirect()->back()->with('error', 'Disease group not found');
    }
}

}
