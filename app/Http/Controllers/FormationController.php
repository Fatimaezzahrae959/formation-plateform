<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with('category')->latest()->paginate(10);
        return view('formations.index', compact('formations'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('formations.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'short_desc_fr' => 'nullable|string',
            'short_desc_en' => 'nullable|string',
            'full_desc_fr' => 'nullable|string',
            'full_desc_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'status' => 'nullable|in:brouillon,publie,archive',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('formations', 'public');
        }

        Formation::create([
            'category_id' => $request->category_id,
            'title_fr' => $request->title_fr,
            'title_en' => $request->title_en,
            'slug_fr' => Str::slug($request->title_fr),
            'slug_en' => Str::slug($request->title_en),
            'short_desc_fr' => $request->short_desc_fr,
            'short_desc_en' => $request->short_desc_en,
            'full_desc_fr' => $request->full_desc_fr,
            'full_desc_en' => $request->full_desc_en,
            'image' => $imagePath,
            'price' => $request->price ?? 0,
            'duration' => $request->duration,
            'level' => $request->level,
            'status' => $request->status ?? 'brouillon',
        ]);

        return redirect()->route('formations.index')->with('success', 'Formation ajoutée avec succès !');
    }

    public function edit(Formation $formation)
    {
        $categories = Category::all();
        return view('formations.edit', compact('formation', 'categories'));
    }

    public function update(Request $request, Formation $formation)
    {
        $request->validate([
            'category_id' => 'nullable|integer',
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'short_desc_fr' => 'nullable|string',
            'short_desc_en' => 'nullable|string',
            'full_desc_fr' => 'nullable|string',
            'full_desc_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'price' => 'nullable|numeric',
            'duration' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:50',
            'status' => 'nullable|in:brouillon,publie,archive',
        ]);

        $data = $request->except('image');
        $data['slug_fr'] = Str::slug($request->title_fr);
        $data['slug_en'] = Str::slug($request->title_en);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($formation->image) {
                \Storage::disk('public')->delete($formation->image);
            }
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        $formation->update($data);

        return redirect()->route('formations.index')->with('success', 'Formation mise à jour avec succès !');
    }

    public function destroy(Formation $formation)
    {
        if ($formation->image) {
            \Storage::disk('public')->delete($formation->image);
        }
        $formation->delete();
        return redirect()->route('formations.index')->with('success', 'Formation supprimée !');
    }
}