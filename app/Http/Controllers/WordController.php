<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $words = Word::all();
        return response()->json($words);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        if ($user->rol_id != 1) {
            return response()->json([
                'status' => false,
                'msg' => 'No tienes permiso para realizar esta acción'
            ], 403);
        }
        $rules = ['wor_english'=>'required|string|min:1|max:100', 'wor_spanish'=>'required|string|min:1|max:100', 'cat_id'=>'required|integer|min:1|max:10'];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ],400);
        }
        $word = new Word($request->input());
        $word->save();
        return response()->json([
            'status' => true,
            'msg' => 'Word saved successfully'
        ],200);
    }


    public function show($id)
    {
        $word = Word::find($id);
        return response()->json([
            'status' => true,
            'data' => $word
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->rol_id != 1) {
            return response()->json([
                'status' => false,
                'msg' => 'No tienes permiso para realizar esta acción'
            ], 403);
        }
        $word = Word::find($id);
        $rules = ['wor_english'=>'required|string|min:1|max:100', 'wor_spanish'=>'required|string|min:1|max:100', 'cat_id'=>'required|integer|min:1|max:10'];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ],400);
        }
        $word->update($request->input());
        return response()->json([
            'status' => true,
            'msg' => 'Word updated successfully'
        ],200);
    }

    public function destroy($id)
    {
        $user = auth()->user();
        if ($user->rol_id != 1) {
            return response()->json([
                'status' => false,
                'msg' => 'No tienes permiso para realizar esta acción'
            ], 403);
        }
        $word = Word::find($id);
        $word->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Word deleted successfully'
        ],200);
    }

    public function find()
    {
        $word = Word::inRandomOrder()->first();
        $word1 = Word::inRandomOrder()->first();
        $word2 = Word::inRandomOrder()->first();
        $word['word1'] = $word1['wor_english'];
        $word['word2'] = $word2['wor_english'];
        return response()->json([
            'status' => true,
            'data' => $word
        ]);
    }
}
