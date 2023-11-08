<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{

    public function store(Request $request)
    {
        $user = auth()->user();
        $rules = ['wor_id'=>'required|integer'];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ],400);
        }
        $result = new result();
        $result->wor_id = $request->input()['wor_id'];
        $result->use_id = $user['use_id'];
        $result->save();
        return response()->json([
            'status' => true,
            'msg' => 'Result saved successfully'
        ],200);
    }

    public function find()
    {
        $user = auth()->user();
        $results = DB::table('results')
        ->join('users', 'results.use_id', '=', 'users.use_id')
        ->join('words', 'results.wor_id', '=', 'words.wor_id')
        ->where('users.use_id', '=', $user['use_id'])->get();
        return response()->json([
            'status' => true,
            'data' => $results
        ]);
    }
}
