<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category', 'auteur')->latest()->paginate(25);
        return view('blogs.index', compact('blogs'));
    }

    public function show($slug)
    {
        $blog = Blog::where('slug_fr', $slug)
            ->orWhere('slug_en', $slug)
            ->with('category', 'auteur')
            ->firstOrFail();

        return view('blogs.show', compact('blog'));
    }

    public function create()
    {
        $categories = Category::all();
        $auteurs = User::whereIn('role', ['admin', 'super_admin', 'formateur'])->get();
        return view('blogs.create', compact('categories', 'auteurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'content_fr' => 'nullable|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:brouillon,publie,archive',
            'published_at' => 'nullable|date',
            'seo_title_fr' => 'nullable|string|max:255',
            'seo_title_en' => 'nullable|string|max:255',
            'meta_desc_fr' => 'nullable|string|max:255',
            'meta_desc_en' => 'nullable|string|max:255',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');
        }

        Blog::create([
            'category_id' => $request->category_id,
            'user_id' => $request->user_id,
            'title_fr' => $request->title_fr,
            'title_en' => $request->title_en,
            'content_fr' => $request->content_fr,
            'content_en' => $request->content_en,
            'image' => $imagePath,
            'status' => $request->status,
            'published_at' => $request->published_at,
            'seo_title_fr' => $request->seo_title_fr,
            'seo_title_en' => $request->seo_title_en,
            'meta_desc_fr' => $request->meta_desc_fr,
            'meta_desc_en' => $request->meta_desc_en,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Article ajouté avec succès !');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $auteurs = User::whereIn('role', ['admin', 'super_admin', 'formateur'])->get();
        return view('blogs.edit', compact('blog', 'categories', 'auteurs'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'user_id' => 'nullable|exists:users,id',
            'content_fr' => 'nullable|string',
            'content_en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status' => 'required|in:brouillon,publie,archive',
            'published_at' => 'nullable|date',
            'seo_title_fr' => 'nullable|string|max:255',
            'seo_title_en' => 'nullable|string|max:255',
            'meta_desc_fr' => 'nullable|string|max:255',
            'meta_desc_en' => 'nullable|string|max:255',
        ]);

        $data = $request->except('image');


        if ($request->hasFile('image')) {
            if ($blog->image) {
                \Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('blogs.index')->with('success', 'Article modifié avec succès !');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            \Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();
        return redirect()->route('blogs.index')->with('success', 'Article supprimé !');
    }
}