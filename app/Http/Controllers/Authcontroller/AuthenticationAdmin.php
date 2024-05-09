<?php

namespace App\Http\Controllers\Authcontroller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Authcontroller\Basecontroller as Basecontroller;

class AuthenticationAdmin extends Basecontroller
{
    use HasApiTokens;
    public function register(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required |unique:users',
                'email' => 'required|unique:users',
                'password' => 'required',
                // 'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'please validate error');
            }
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $user->type = 'admin';
            $user->save();
            $success['token'] = $user->createToken('ahmadghazal')->plainTextToken;
            $success['name'] = $user->name;
            DB::commit();
            return $this->sendresponse($success, 'Admin register successfly');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->senderror($validator->errors(), 'please validate error');
        }
    }
    public function login(Request $request, User $user)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->senderror('Unauthorized', ['error', 'Unauthorized']);
        }
        $users = $request->user();
        $success['token'] =  $users->createToken('ahmadghazal')->plainTextToken;
        $success['name'] = $users->name;
        return $this->sendresponse($success, 'Admin login successfly');
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendresponse(['message' => 'Admin logout successfly'], 200);
    }
    public function delete(Request $request)
    {
        $user = Auth::user();
        $request->user()->delete();
        //$user->profile->delete();
        return $this->sendresponse(['message' => 'Admin delete successfly'], 200);
    }



}
