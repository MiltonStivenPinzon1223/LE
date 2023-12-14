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
        $result = new result();
        $result->wor_id = $request->input()['wor_id'];
        $result->use_id = $request->input()['use_id'];
        $result->save();
        return response()->json([
            'msg'=>'Result saved successfully'
        ],200);
    }

    public function find()
    {
        $user = auth()->user();
        $results = DB::table('results')
        ->join('users', 'results.use_id', '=', 'users.use_id')
        ->join('words', 'results.wor_id', '=', 'words.wor_id')
        ->where('users.use_id', '=', 11)->get();
        foreach ($results as $result) {
            unset($result->res_id);
            unset($result->use_id);
            unset($result->wor_id);
            unset($result->updated_at);
            unset($result->use_name);
            unset($result->use_email);
            unset($result->use_password);
            unset($result->use_status);
            unset($result->email_verified_at);
            unset($result->rol_id);
            unset($result->remember_token);
            unset($result->cat_id);
        }
        return response()->json([
            'Results' => $results
        ]);
    }


    public function forCategory(){
        $user = auth()->user();
        $categories = Category::all();
        foreach ($categories as $category) {
            $percentage = 0;
            $words = DB::table('words')->where('cat_id', $category['cat_id'])->get();
            foreach ($words as $word) {
                $check = DB::table('results')->where("wor_id", "=", $word->wor_id)->where("use_id", "=", "11")->get()->first();
                if ($check != null) {
                    $percentage+=1;
                }
            }
            $cant = count($words);
            $category['cat_progress'] = round(($percentage / $cant) * 100);
        }
        $array = array(
            "categories" => $categories,
        );
        return $array;
    }
}
