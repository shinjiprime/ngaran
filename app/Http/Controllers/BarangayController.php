<?php

namespace App\Http\Controllers;

use App\Models\Barangay;
use App\Models\Municipality;
use Illuminate\Http\Request;

class BarangayController extends Controller
{
    // Display all barangays with municipalities
    public function index()
    {
        $barangays = Barangay::with('municipality')->get(); // Eager load municipalities
        $municipalities = Municipality::all(); // Fetch all municipalities
        return view('adminpages.barangays', compact('barangays', 'municipalities'));
    }

    // Store a new barangay
    public function store(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'barangay_name' => 'required|string|max:255',
            'coordinates' => 'required|string',
            'municipality_id' => 'required|exists:municipalities,id',
        ]);

        Barangay::create($validatedData); // Create a new barangay

        return redirect()->back()->with('success', 'Barangay added successfully!');
    }

    // Update an existing barangay
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'barangay_name' => 'required|string|max:255',
            'coordinates' => 'required|string',
            'municipality_id' => 'required|exists:municipalities,id',
        ]);

        $barangay = Barangay::find($id);
        if (!$barangay) {
            return redirect()->back()->with('error', 'Barangay not found');
        }

        $barangay->update($validatedData); // Update barangay details

        return redirect()->back()->with('success', 'Barangay updated successfully');
    }

    // Delete a barangay
    public function destroy($id)
    {
        $barangay = Barangay::find($id);
        if ($barangay) {
            $barangay->delete();
            return redirect()->back()->with('success', 'Barangay deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Barangay not found');
        }
    }
}
