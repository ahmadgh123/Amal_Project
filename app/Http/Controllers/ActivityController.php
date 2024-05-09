<?php

namespace App\Http\Controllers;

use App\Models\User\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Activity as ActivityResourse;

class ActivityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function get_activity($id)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                $activity = Activity::where('section_id', $id)->get();
                return $this->sendresponse(ActivityResourse::collection($activity), 'private activity');
            } catch (\Exception $e) {
                return $this->senderror($e, 'the activity not found');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                $validator = Validator::make($request->all(), [
                    'NameE' => 'required',
                    'NameA' => 'required',
                    'level_activity' => 'required',
                    'section_id' => 'required',
                    'pic' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048|nullable'
                ]);
                if ($validator->fails()) {
                    return $this->senderror($validator->errors(), 'please validate error00');
                }
                if ($request->has('pic')) {
                    $activity = new Activity;
                    $file = $request->file('pic');
                    $filedata = file_get_contents($request->pic);
                    $mimetype = $file->getMimeType();
                    $activity->NameA = $request->NameA;
                    $activity->NameE = $request->NameE;
                    $activity->level_activity = $request->level_activity;
                    $activity->section_id = $request->section_id;
                    $activity->photo_type = $mimetype;
                    $activity->activity_image = $filedata;
                    $activity->save();
                    return $this->sendresponse(new ActivityResourse($activity), 'Store Activity sucssesful');
                } else {
                    return $this->senderror('please validate error-->Activity not Storing');
                }
            } catch (\Exception $e) {
                return $this->senderror($e, 'please validate error--->Activity not Storing');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                $activity = Activity::find($activity);
                return $this->sendresponse(ActivityResourse::collection($activity), 'show specified activity');
            } catch (\Exception $e) {
                return $this->senderror($e, 'the activity not found');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                $validator = Validator::make($request->all(), [
                    'NameE' => 'required',
                    'NameA' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->senderror($validator->errors(), 'please validate error');
                }
                $activity->NameA = $request->NameA;
                $activity->NameE = $request->NameE;
                $activity->save();
                return $this->sendresponse(['message' => 'activity update name successfly'], 200);
            } catch (\Exception $e) {
                return $this->senderror($e, 'please validate error-->activity not Storing');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }

    public function update_photo_activity(Request $request, Activity $activity)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                $validator = Validator::make($request->all(), [
                    'pic' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048'
                ]);
                if ($request->has('pic')) {
                    $file = $request->file('pic');
                    $filedata = file_get_contents($request->pic);
                    $mimetype = $file->getMimeType();
                    $activity->photo_type = $mimetype;
                    $activity->activity_image = $filedata;
                    $activity->save();
                    return $this->sendresponse($activity->NameE, 'Activity update photo successfly');
                } else {
                    return $this->senderror('please validate error-->Activity photo not Storing');
                }
            } catch (\Exception $e) {
                return $this->senderror($e, 'please validate error-->Activity photo not Storing');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                //$section->course()->get(['id'])->each->delete();
                //$section->game()->get(['id'])->each->delete();
                $activity->delete();
                return $this->sendresponse(['message' => 'activity delete successfly'], 200);
            } catch (\Exception $e) {
                return $this->senderror($e, 'please delete error');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }
}
