<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RHU; 
use App\Models\Municipality;
use App\Models\HealthFacility;// Make sure to import your RHU model

class RHUController extends Controller
{
    // Display a listing of the RHUs
    public function index()
{
    // Fetch RHUs with associated municipalities and map coordinates from HealthFacility
    $rhus = Rhu::with('municipality')->get()->map(function ($rhu) {
        $rhu->coordinates = HealthFacility::where('facility_type', 2)
            ->where('rhu_id', $rhu->rhu_id)
            ->value('coordinates');
        return $rhu;
    });

    // Fetch all municipalities
    $municipalities = Municipality::all();

    // Pass both RHUs and municipalities to the view
    return view('adminpages.rhus', compact('rhus', 'municipalities'));
}

    // Store a newly created RHU in storage
    public function create(Request $request) 
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'rhu_name' => 'required|string|max:255',
        'municipality_id' => 'required',
        'coordinates' => 'nullable|string', // Optional coordinates field
    ]);

    // Step 1: Create a new RHU object
    $rhu = Rhu::create([
        'rhu_name' => $validatedData['rhu_name'],
        'municipality_id' => $validatedData['municipality_id'],
    ]);

    // Step 2: Create a Health Facility object associated with the RHU
    HealthFacility::create([
        'facility_name' => $rhu->rhu_name,
        'facility_type' => 2, // Type "2" as specified
        'barangay_id' => null, // Barangay ID is null
        'rhu_id' => $rhu->rhu_id, // Link to the RHU created earlier
        'coordinates' => $validatedData['coordinates'], // Use coordinates if provided
    ]);

    // Redirect to the RHU index with success message
    return redirect()->route('rhus.index')->with('success', 'RHU and associated Health Facility created successfully.');
}

    // Update the specified RHU in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'rhu_name' => 'required|string|max:255',
            'municipality_id' => 'required|exists:municipalities,id',
        ]);

        $rhu = Rhu::findOrFail($id);
        $rhu->update($request->all());

        return redirect()->route('rhus.index')->with('success', 'RHU updated successfully.');
    }

    // Remove the specified RHU from storage
    public function destroy($id)
    {
        $rhu = Rhu::findOrFail($id);
        $rhu->delete();

        return redirect()->route('rhus.index')->with('success', 'RHU deleted successfully.');
    }
    public function updateLocation2(Request $request) 
{
    return response()->json($request->all());
}
public function fetchRhus()
{
    $rhus = Rhu::with('municipality')->get()->map(function ($rhu) {
        $rhu->coordinates = HealthFacility::where('facility_type', 2)
            ->where('rhu_id', $rhu->rhu_id)
            ->value('coordinates');
        return $rhu;
    });

    return view('adminpages.partials.rhus', compact('rhus'))->render();
}

}    