<?php

namespace App\Http\Controllers;

use App\Models\User\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Authcontroller\Basecontroller as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Profile as ProfileResourse;
use App\Http\Resources\User as UserResource;

class ProfileController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $id = Auth::id();
        if ($user->profile == null) {
            $s = random_int(1, 200);
            Profile::create([
                'user_id' => $id,
                'phone' => "Ex$s: 099764797",
                'gender' => 'Ex: mail ',
                'date_of_birth' => '2023-5-8',
                'location' => 'Ex: Syria',
            ]);
            $profile = Profile::where('user_id', Auth::user()->id)->get();
            $data =  User::where('id', Auth::user()->id)->get();
            return $this->sendresponse([UserResource::collection($data), ProfileResourse::collection($profile)], 'user profile');
        } else {
            $data =  User::where('id', Auth::user()->id)->get();
            $profile = Profile::where('user_id', Auth::user()->id)->get();
            $profile_id = Profile::where('user_id', Auth::user()->id)->first()->id;
            $fech = Profile::find($profile_id);
            $getfile = "data:" . $fech['photo_type'] . ";base64," . base64_encode($fech['profile_image']);
            echo '<img src="' . $getfile . '" height=50px width=50px"/>';
            return $this->sendresponse([UserResource::collection($data), ProfileResourse::collection($profile)], 'user profile');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|',
                'email' => 'required|email',
                'phone' => 'required',
                'gender' => 'required',
                'date_of_birth' => 'required',
                'location' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }
            $user = Auth::user();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->profile->phone = $request['phone'];
            $user->profile->gender =  $request['gender'];
            $user->profile->date_of_birth = $request['date_of_birth'];
            $user->profile->location = $request['location'];
            $user->save();
            $user->profile->save();
            if ($request->has('password')) {
                $user->password = bcrypt($request->password);
                $user->save();
            }

            return $this->sendresponse($user->name, 'user update profile sucssesful');
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error');
        }
    }
    /**
     *  FUNCTION UPDATE PROFILE PHOTO ------:)
     *
     * @param  \App\Models\User\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update_photo_profile(Request $request, Profile $profile)
    {
        try {
            $validator = Validator::make($request->all(), [
                'profile_image' => 'required|mimes:pdf,docx,txt,jpg,png|max:2048'
            ]);
            if ($request->has('profile_image')) {
                $file = $request->file('profile_image');
                $filedata = file_get_contents($request->profile_image);
                $mimetype = $file->getMimeType();
                $profile->photo_type = $mimetype;
                $profile->profile_image = $filedata;
                $profile->save();
                return $this->sendresponse(true, 'Profile update photo successfly');
            } else {
                return $this->senderror('please validate error-->Profile photo not Storing');
            }
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error-->Profile photo not Storing');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        try {
            $destroy = Auth::user();
            $destroy->profile->delete();
            return $this->sendresponse(['message' => 'profile delete successfly'], 200);
        } catch (\Exception $e) {
            return $this->senderror($e, 'please validate error');
        }
    }
}
