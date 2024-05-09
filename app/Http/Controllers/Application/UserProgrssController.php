<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\UserProgres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserProgrssController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function recordProgress(Request $request)
    {
        $userProgress = new UserProgres();
        $userProgress->user_id = Auth::user()->id;
        $userProgress->activity_id = $request->activity_id;
        $userProgress->completed_at = now();
        $userProgress->save();
        $vv=$request->activity_id;
        return response()->json([
            'Success' => true,
            'Message' => 'Data saved',
        ], 200);
    }

    public function retrieveProgress(Request $request)
    {
        $userProgressActivities = UserProgres::with('activity.section')
        ->where('user_id', auth::user()->id)
        ->get()
        ->pluck('Activity')
        ->where('section.id', $request->query('sectionId'))
        ->unique('id')
        ->values()
        ->map(function ($Activity) {
            return [
                'id' => $Activity->id,
                'activity_name' => $Activity->NameE,
            ];
        });
        if ($userProgressActivities->isEmpty()) {
            return response()->json(['message' => 'No Activities found for this user in this section'], 404);
        }
    return $userProgressActivities;
    }
}
