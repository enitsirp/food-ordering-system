<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use Illuminate\Support\Facades\Validator;

class MenuCategoryController extends Controller
{
    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.menu.category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $categories = MenuCategory::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'category' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return MenuCategory::create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'category' => ['required', 'string', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category = MenuCategory::find($id);
        return $category->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = MenuCategory::find($id);
        $delete = $category->delete();
        return response()->json($delete);
    }
}
