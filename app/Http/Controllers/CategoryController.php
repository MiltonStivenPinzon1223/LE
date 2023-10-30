<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $rules = ['cat_category'=>'required|string|min:1|max:100'];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ],400);
        }
        $category = new Category($request->input());
        $category->save();
        return response()->json([
            'status' => true,
            'msg' => 'Category saved successfully'
        ],200);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return response()->json([
            'status' => true,
            'data' => $category
        ]);
    }



    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $rules = ['cat_category'=>'required|string|min:1|max:100'];
        $validator = Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors'=>$validator->errors()->all()
            ],400);
        }
        $category->update($request->input());
        return response()->json([
            'status' => true,
            'msg' => 'Category updated successfully'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'status' => true,
            'msg' => 'Category deleted successfully'
        ],200);
    }
}