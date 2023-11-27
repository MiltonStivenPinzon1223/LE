<?php

namespace App\Http\Controllers;

use App\Models\Category;
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


    public function forCategory(){
        $user = auth()->user();
        $categories = Category::all();
        foreach ($categories as $category) {
            $percentage = 0;
            $words = DB::table('words')->where('cat_id', $category['cat_id'])->get();
            foreach ($words as $word) {
                $check = DB::table('results')->where("wor_id", "=", $word->wor_id)->where("use_id", "=", $user['use_id'])->get()->first();
                if ($check != null) {
                    $percentage+=1;
                }
            }
            $cant = count($words);
            $category['percentage'] = ($percentage / $cant) * 100;
        }
        return $categories;
    }
}
