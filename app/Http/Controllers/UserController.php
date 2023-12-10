<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'data' => $user,
        ],200);
    }

    public function store(Request $request)
    {
        return response()->json([
            'status' => true,
            'msg' => 'You do not have access to this function',
        ],200);
    }

    public function show($id)
    {
        $msg = array(
            "status" => true,
            "msg" => "You do not have access to this function"
        );
        return $msg;
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'use_name' => 'required|string|max:100',
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
        $user = User::find($id);
        $user->use_name = $request->use_name;
        $user->use_email = $request->use_email;
        $user->use_password = $request->use_password;
        $user->update();
        return response()->json([
            'status' => true,
            'msg' => 'Updated successful',
        ],200);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $newStatus = ($user['use_status'] == 0) ? 1 : 0;
        $user->where('use_id',$id)
       ->update(['use_status'=>$newStatus]);
    }
}
