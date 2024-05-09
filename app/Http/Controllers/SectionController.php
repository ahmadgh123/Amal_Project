<?php

namespace App\Http\Controllers;

use App\Models\User\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Section as SectionResourse;

class SectionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                $section = Section::all();
                return $this->sendresponse(SectionResourse::collection($section), 'all sections');
            } catch (\Exception $e) {
                return $this->senderror($e, 'the section not found');
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
                    'pic' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048|nullable'
                ]);
                if ($validator->fails()) {
                    return $this->senderror($validator->errors(), 'please validate error');
                }
                if ($request->has('pic')) {
                    $section = new Section;
                    $file = $request->file('pic');
                    $filedata = file_get_contents($request->pic);
                    $mimetype = $file->getMimeType();
                    $section->name_section = $request->NameA;
                    $section->slug = $request->NameE;
                    $section->photo_type = $mimetype;
                    $section->section_image = $filedata;
                    $section->save();
                    return $this->sendresponse(new SectionResourse($section), 'Store Section sucssesful');
                } else {
                    return $this->senderror('please validate error-->Section not Storing');
                }
            } catch (\Exception $e) {
                return $this->senderror($e, 'please validate error-->Section not Storing');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                $section = Section::find($section);
                // dd($section);
                return $this->sendresponse(SectionResourse::collection($section), 'show specified sections');
            } catch (\Exception $e) {
                return $this->senderror($e, 'the section not found');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
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
                $section->name_section = $request->NameA;
                $section->slug = $request->NameE;
                $section->save();
                return $this->sendresponse(['message' => 'section update name successfly'], 200);
            } catch (\Exception $e) {
                return $this->senderror($e, 'please validate error-->Section not Storing');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }
    public function update_photo_section(Request $request, Section $section)
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
                    $section->photo_type = $mimetype;
                    $section->section_image = $filedata;
                    $section->save();
                    return $this->sendresponse($section->name_section, 'section update photo successfly');
                } else {
                    return $this->senderror('please validate error-->Section photo not Storing');
                }
            } catch (\Exception $e) {
                return $this->senderror($e, 'please validate error-->Section photo not Storing');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $admin = Auth::user();
        if ($admin->type == 'admin') {
            try {
                //$section->course()->get(['id'])->each->delete();
                //$section->game()->get(['id'])->each->delete();
                $section->delete();
                return $this->sendresponse(['message' => 'section delete successfly'], 200);
            } catch (\Exception $e) {
                return $this->senderror($e, 'please delete error');
            }
        } else {
            return $this->senderror(false, 'the Auth is not Admin', 404);
        }
    }
}
