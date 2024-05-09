<?php

namespace App\Http\Controllers\application;

use App\Http\Controllers\Controller;
use App\Models\Result;
use App\Models\User\Activity;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    public function ReqActivities()
    {
        // Get the Activities with the highest 'repet' value for the user
        $highestRepetActivity = Result::with('activity')
            ->where('user_id', Auth::user()->id)
            ->orderBy('repet', 'desc')
            ->first();

        if (!$highestRepetActivity) {
            return response()->json(['message' => 'No results found for this user'], 404);
        }

        // Get all Activities in the same section as the highest 'repet' activity
        $suggestedActivities = Activity::where('section_id', $highestRepetActivity->activity->section_id)
            ->whereNotIn('id', function ($query) {
                $query->select('activity_id')
                    ->from('results')
                    ->where('user_id', auth::user()->id);
            })
            ->get();

        return $suggestedActivities;
    }
}
