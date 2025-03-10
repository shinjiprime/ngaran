<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\HealthFacility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Submission;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function sendNotification(Request $request)
    {
        $rhuIds = $request->input('rhu_ids', []); // Expect an array of RHU IDs
    
        if (empty($rhuIds)) {
            return response()->json(['message' => 'No RHUs selected'], 400);
        }
    
        // Fetch facilities for the selected RHUs
        $facilities = HealthFacility::whereIn('rhu_id', $rhuIds)
            ->where('facility_type', 2)
            ->get();
    
        if ($facilities->isEmpty()) {
            return response()->json(['message' => 'No facilities found for the selected RHUs'], 404);
        }
    
        foreach ($facilities as $facility) {
            Notification::create([
                'receiver' => $facility->facility_id,
                'message' => 'PHOLeyte: Please submit before the end of the month',
                'status' => 'unread',
                'date' => now(),
            ]);
        }
    
        return response()->json(['message' => 'Notifications sent successfully'], 200);
    }
    
public function sendNotification2(Request $request)
{
    $facilityId = $request->input('facility_id');

    // Fetch the facility based on the provided facility_id and conditions
    $facility = HealthFacility::whereIn('facility_type', [3, 4])
        ->where('facility_id', $facilityId)
        ->first();

    if (!$facility) {
        return response()->json(['message' => 'Health Facility not found'], 404);
    }

    // Create a new notification
    Notification::create([
        'receiver' => $facility->facility_id,
        'message' => 'RHU: Please submit patient records before the end of the month',
        'status' => 'unread',
        'date' => now(),
    ]);

    return response()->json(['message' => 'Notification sent successfully'], 200);
}

public function markAsRead($id)
{
    $notification = Notification::find($id);

    if ($notification) {
        // Update the status to 'read'
        $notification->status = 'read';
        $notification->save();

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false], 404);
}


public function deleteReadNotifications()
{
    $facilityId = Session::get('facility_id'); // Get the current session's facility_id

    // Delete all read notifications for the current facility
    Notification::where('receiver', $facilityId)
                ->where('status', 'read')
                ->delete();

    return response()->json(['success' => true, 'message' => 'Read notifications deleted successfully.']);
}
public function refreshNotifications()
{
    $facilityId = Session::get('facility_id');

    $unreadNotifications = Notification::where('receiver', $facilityId)
                                        ->where('status', 'unread')
                                        ->get();
    $readNotifications = Notification::where('receiver', $facilityId)
                                      ->where('status', 'read')
                                      ->get();

    return view('masterrhu.partials.notifications', compact('unreadNotifications', 'readNotifications'));
}
public function store(Request $request)
    {
        try {
            $facility_id = session('facility_id'); // Retrieve facility_id from session
            $date = Carbon::now(); // Get current date

            // Create a new submission
            Submission::create([
                'facility_id' => $facility_id,
                'date' => $date
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }


}

