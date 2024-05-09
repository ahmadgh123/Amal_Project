<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Resources\Application\NeedResources;
use App\Models\Need;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class NeedController extends Controller
{

    use HasApiTokens;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index($value)
    {
        $id = auth::user()->id;
        $data = Need::where('type', $value)
            ->where('user_id', $id)
            ->orWhereNull('user_id')
            ->where('type', $value)
            ->get();
        $count = $data->count();
        return response()->json([
            'success' => true,
            'Count' => $count,
            'Data' => NeedResources::collection($data),
        ]);
    }

    // for dashboard
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'name' => 'required|string',
            'slug' => 'required|string',
            'image' => 'required|mimes:jpg,png|',
            'voice' => 'required|mimes:jpg,png,mp3,mp4,avi,flv,webm,m4a,3gp,wav',
        ], [
            'type.required' => 'The type field is required.',
            'image.required' => 'The image field is required.',
            'voice.required' => 'The voice field is required.',
            'name.required' => 'The name field is required.',
            'slug.required' => 'The slug field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->has('image') or $request->has('voice')) {
            $need = new Need();
            $file = $request->file('image');
            $file_voice = $request->file('voice');
            $filedata = file_get_contents($request->image);
            $filedata_voice = file_get_contents($request->voice);
            $mimetype = $file->getMimeType();
            $mimetype_voice = $file_voice->getMimeType();
            $need->type = $request->type;
            $need->name = $request->name;
            $need->slug = $request->slug;
            $need->photo_type = $mimetype;
            $need->voice_type = $mimetype_voice;
            $need->image = $filedata;
            $need->voice = $filedata_voice;
            $need->save();
        }
        return response()->json([
            'success' => true,
            'Message' => 'Data has been successfully saved.',
        ]);
    }

    // store for parents

    public function store_need(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'image' => 'required|mimes:jpg,png|',
            'voice' => 'required|mimes:jpg,png,mp3,mp4,avi,flv,webm,m4a,3gp,wav',
        ], [
            'type.required' => 'The type field is required.',
            'image.required' => 'The image field is required.',
            'voice.required' => 'The voice field is required.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->has('image') or $request->has('voice')) {
            $need = new Need();
            $file = $request->file('image');
            $file_voice = $request->file('voice');
            $filedata = file_get_contents($request->image);
            $filedata_voice = file_get_contents($request->voice);
            $mimetype = $file->getMimeType();
            $mimetype_voice = $file_voice->getMimeType();
            $need->type = $request->type;
            $need->name = $request->name;
            $need->user_id = auth::user()->id;
            $need->slug = $request->slug;
            $need->photo_type = $mimetype;
            $need->voice_type = $mimetype_voice;
            $need->image = $filedata;
            $need->voice = $filedata_voice;
            $need->save();
        }
        return response()->json([
            'success' => true,
            'Message' => 'Data has been successfully saved.',
        ]);
    }
}
