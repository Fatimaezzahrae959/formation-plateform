<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_fr' => 'required',
            'name_en' => 'required'
        ]);

        Category::create([
            'name_fr' => $request->name_fr,
            'name_en' => $request->name_en,
            'slug_fr' => Str::slug($request->name_fr),
            'slug_en' => Str::slug($request->name_en),
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name_fr' => $request->name_fr,
            'name_en' => $request->name_en,
            'slug_fr' => Str::slug($request->name_fr),
            'slug_en' => Str::slug($request->name_en),
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée');
    }

    public function destroy($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('categories.index')->with('success', 'Supprimée');
    }
}