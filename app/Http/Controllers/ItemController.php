<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();

        return View::make('items.index')
            ->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return View::make('items.create')
            ->with('categories', $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5|max:80',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'image_path' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $file = $request->file('image_path');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('images', $fileName, 'public'); 

        Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image_path' => $filePath
        ]);
        
        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::find($id);
        $categories = Category::all();
        return View::make('items.edit')
            ->with('categories', $categories)
            ->with('item', $item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:5|max:80',
            'price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
            'image_path' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $file = $request->file('image_path');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('images', $fileName, 'public'); 

        $item = Item::find($id);
        $item->name = $request->name;
        $item->price = $request->price;
        $item->stock = $request->stock;
        $item->category_id = $request->category_id;
        $item->image_path = $request->image_path;
        $item->save();

        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Item::destroy($id);

        return redirect()->route('items.index');
    }
}
