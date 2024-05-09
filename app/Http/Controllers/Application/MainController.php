<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Authcontroller\Basecontroller;
use App\Http\Resources\Activity as ResourcesActivity;
use App\Http\Resources\Application\ProfileResources;
use App\Http\Resources\Course as CourseResourse;
use App\Http\Resources\Game as GameResourse;
use App\Http\Resources\N_Course as ResourcesN_Course;
use App\Http\Resources\N_Game as ResourcesN_Game;
use App\Models\FeedBack;
use App\Models\User;
use App\Models\User\Activity;
use App\Models\User\Course;
use App\Models\User\Game;
use App\Models\User\N_Course;
use App\Models\User\N_Game;
use App\Models\User\Section;
use App\Services\SectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class MainController extends Basecontroller
{

    use HasApiTokens;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function Sections(SectionService $section)
    {
        return $section->getAllSections();
    }

    public function Activities()
    {
        try {
            $Activities = Activity::all();
            return $this->sendresponse(
                ResourcesActivity::collection($Activities), 'All Courses'
            );
        } catch (\Exception $e) {
            return $this->senderror($e, 'The Courses Not found');
        }
    }


    public function Profile()
    {
        try {
            $Profile = User::find(auth::id());
            return $this->sendresponse(
                new ProfileResources($Profile), 'none'
            );
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function SectionBody($sectionName, SectionService $body)
    {
        return $body->SectionBody($sectionName);
    }

    public function feedback(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
        ], [
            'message.required' => 'The message field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $feedback = new FeedBack();
        $feedback->message = $request->message;
        $feedback->user_id = auth()->user()->id;
        $feedback->save();

        return response()->json([
            'success' => true,
            'message' => 'Data has been successfully saved.',
        ]);
    }

    public function ChooseCourse($id)
    {
        $courses = N_Course::where('id', $id)->get();
        if ($courses->isEmpty()) {
            return response()->json([
                'message' => 'Course not found',
            ]);
        }
        return response()->json([
            'courses' => ResourcesN_Course::collection($courses),
        ]);

    }


    public function selectCourse($sectionId, $ActivityId)
    {
        $section = Section::find($sectionId);
        $Activity = Activity::find($ActivityId);
        $photos = $section->photos()->where('activity_id', $ActivityId)->get();

        return response()->json([
            'section'=>$section->name_section,
            'course'=>$Activity->NameE,
            'Count' => $photos->count(),
            'List' => ResourcesN_Course::collection($photos),
        ]);

    }

}
