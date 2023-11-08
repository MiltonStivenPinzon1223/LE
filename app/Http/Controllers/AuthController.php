<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected $username = 'use_password';

    function register(Request $request) {
        $rules = [
            'use_name' => 'required|string|max:100',
            'use_email' => 'required|string|email|max:200|unique:users',
            'use_password' => 'required|string|min:min|max:100',
        ];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ],400);
        }
        $user = User::create([
            'use_name' => $request->use_name,
            'use_email' => $request->use_email,
            'use_password' => Hash::make($request->use_password),
            'rol_id' => 2,
        ]);
        return response()->json([
            'status' => true,
            'msg' => 'Registration successful',
            'token' => $user->createToken('API TOKEN')->plainTextToken,
        ],200);
    }


    function login(Request $request){
        $rules = [
            'use_email' => 'required|string|email|max:200',
            'use_password' => 'required|string|min:min|max:100',
        ];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ],400);
        }
        if (Auth::attempt(['use_email' => $request['use_email'], 'password' => $request['use_password']])) {
            return response()->json([
                'status' => false,
                'errors'=>"Unauthorized"
            ],401);
        }
        $user = User::where('use_email', $request->use_email)->first();
        return response()->json([
            'status' => true,
            'msg' => 'User logged success',
            'token' => $user->createToken('API TOKEN')->plainTextToken,
        ],200);
    }

    function logout() {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Session closed successfully'
        ],200);
    }
}
