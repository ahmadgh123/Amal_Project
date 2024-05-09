<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Authcontroller\Basecontroller as Basecontroller;
use App\Mail\SendCodeResetPassword;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;

class AuthController extends Basecontroller
{
    use HasApiTokens;

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except'
        => ['login', 'register','ForgotPassword','CodeCheck','Reset']
        ]);
        // $this->guard = "api";
    }
    public function register(Request $request)
    {

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'email||unique:users',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return $this->senderror($validator->errors(), 'Validation Error');
            }
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $success['token'] = $user->createToken('token')->plainTextToken;
            $success['name'] = $user->name;
            DB::commit();
            return $this->sendresponse($success, 'User Register Successfly');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->senderror($validator->errors(), 'please validate error');
        }
    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required|string',
        ]);
        if ($validator->fails()) {
            return $this->senderror($validator->errors(), 'Validation Error');
        }
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return $this->senderror('Unauthorized', ['Unauthorized']);
        }
        $users = $request->user();
        $success['token'] = $users->createToken('token')->plainTextToken;
        $success['name'] = $users->name;
        return $this->sendresponse($success, 'User Login Successfly');
    }
    public function logout(Request $request)
    {

       $user = auth::user()->name;
        $request->user()->currentAccessToken()->delete();
        // auth::logout();
        return $this->sendresponse(['message' => 'User Logout Successfly',
                                    'user' => $user,
                                     ], 200);
    }
    public function delete(Request $request)
    {
        $user = Auth::user();
        $request->user()->delete();
        // $user->profile->delete();
        return $this->sendresponse(['message' => 'user delete successfly'], 200);
    }

    /*
     * Get authenticated user details
     */
    public function userinfo(Request $request)
    {
        return $request->user();
    }

    public function ForgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Failed to reset password'], 200);
        }

        ResetCodePassword::where('email', $request->email)->delete();

        $data['email'] = $request->email;
        $data['code'] = mt_rand(100000, 999999);

        $codeData = ResetCodePassword::create($data);

        Mail::to($request->email)->send(new SendCodeResetPassword($codeData->code));

        return response(['message' => 'code sent'], 200);
    }

    public function CodeCheck(Request $request)
    {
        $request->validate([
            'code' => 'required|string|exists:reset_code_passwords',
        ]);

        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => 'passwords code is expire'], 422);
        }

        return response([
            'code' => $passwordReset->code,
            'message' => 'passwords.code_is_valid',
        ], 200);
    }

    public function Reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|string|exists:reset_code_passwords',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Failed to reset password'], 200);
        }

        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

        if ($passwordReset->created_at > now()->addHour()) {
            $passwordReset->delete();
            return response(['message' => 'passwords code is expire'], 422);
        }

        $user = User::firstWhere('email', $passwordReset->email);

        $user->password = Hash::make($request->password);
        $user->save();

        $passwordReset->delete();

        return response(['message' => 'password has been successfully reset'], 200);
    }
}
