<?php

namespace App\Http\Controllers;

use App\Models\FeedBack;
use Illuminate\Http\Request;

class FeedBackController extends Controller
{
    public function getallFeedBacks()
    {

        $feedbacks = FeedBack::with('user')->get();

        $feedbackData = [];
        foreach ($feedbacks as $feedback) {
            $feedbackData[] = [
                'FeedBack'=>$feedback->message,
                'UserName' => $feedback->user->name,
                'Date' => $feedback->created_at,
            ];
        }
        return response()->json([
            'Count FeedBacks'=>$feedback->count(),
            'data' => $feedbackData,
            'status' => 'Success',
        ], 200);
    }
}
