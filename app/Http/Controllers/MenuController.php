<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MenuCategory;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MenuCategory $category)
    {
        return view('admin.menu.items', compact('category'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(MenuCategory $category)
    {
        $menus = $category->menus;
        return response()->json($menus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuCategory $category, Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'menu' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'tax' => ['required', 'numeric']
        ]);

        $data['category_id'] = $category->id;
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        return Menu::create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MenuCategory $category, Request $request, $id)
    {

        $data = $request->all();
        $validator = Validator::make($data, [
            'menu' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'tax' => ['required', 'numeric']
        ]);

        $data['category_id'] = $category->id;
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }


        $menu = Menu::find($id);
        return $menu->update($data);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuCategory $category, $id)
    {
        $menu = Menu::find($id);
        $delete = $menu->delete();
        return response()->json($delete);
    }
}
