<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // 📌 LIST
    public function index()
    {
        $categories = Category::paginate(25);
        return view('categories.index', compact('categories'));
    }

    // 📌 CREATE
    public function create()
    {
        return view('categories.create');
    }

    // 📌 STORE
    public function store(Request $request)
    {
        $request->validate([
            'name_fr' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $nameFr = $request->input('name_fr');
        $nameEn = $request->input('name_en');

        $category = new Category();
        $category->name_fr = $nameFr;
        $category->name_en = $nameEn;

        // توليد slug مباشرة هنا
        $category->slug_fr = $this->generateSlug($nameFr, 'slug_fr');
        $category->slug_en = $this->generateSlug($nameEn, 'slug_en');

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category créée avec succès!');
    }

    protected function generateSlug(string $title, string $column): string
    {
        $slug = \Str::slug($title);
        $original = $slug;
        $count = 1;

        while (Category::where($column, $slug)->exists()) {
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }
    // 📌 EDIT
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // 📌 UPDATE
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name_fr' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
        ]);

        $category->update([
            'name_fr' => $request->name_fr,
            'name_en' => $request->name_en,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie modifiée avec succès !');
    }

    // 📌 DELETE
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}