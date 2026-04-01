@extends('layouts.app')

@section('title', 'Modifier Article')

@section('content')

    <h2 class="title">Modifier Article</h2>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Titre FR</label>
            <input type="text" name="title_fr" value="{{ old('title_fr', $blog->title_fr) }}" required>
        </div>

        <div class="form-group">
            <label>Titre EN</label>
            <input type="text" name="title_en" value="{{ old('title_en', $blog->title_en) }}" required>
        </div>

        <div class="form-group">
            <label>Catégorie</label>
            <select name="category_id">
                <option value="">-- Aucune --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $blog->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name_fr }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Auteur</label>
            <select name="user_id">
                <option value="">-- Aucun --</option>
                @foreach($auteurs as $auteur)
                    <option value="{{ $auteur->id }}" {{ old('user_id', $blog->user_id) == $auteur->id ? 'selected' : '' }}>
                        {{ $auteur->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Contenu FR</label>
            <textarea name="content_fr" rows="6">{{ old('content_fr', $blog->content_fr) }}</textarea>
        </div>

        <div class="form-group">
            <label>Contenu EN</label>
            <textarea name="content_en" rows="6">{{ old('content_en', $blog->content_en) }}</textarea>
        </div>

        <div class="form-group">
            <label>Image actuelle</label><br>
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}"
                    style="width:80px;height:80px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
            @else
                <span>Aucune image</span>
            @endif
            <label>Changer l'image</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div class="form-group">
            <label>Statut</label>
            <select name="status" required>
                <option value="brouillon" {{ old('status', $blog->status) == 'brouillon' ? 'selected' : '' }}>Brouillon
                </option>
                <option value="publie" {{ old('status', $blog->status) == 'publie' ? 'selected' : '' }}>Publié</option>
                <option value="archive" {{ old('status', $blog->status) == 'archive' ? 'selected' : '' }}>Archivé</option>
            </select>
        </div>

        <div class="form-group">
            <label>Date de publication</label>
            <input type="date" name="published_at" value="{{ old('published_at', $blog->published_at) }}">
        </div>

        <div class="form-group">
            <label>SEO Title FR</label>
            <input type="text" name="seo_title_fr" value="{{ old('seo_title_fr', $blog->seo_title_fr) }}">
        </div>

        <div class="form-group">
            <label>SEO Title EN</label>
            <input type="text" name="seo_title_en" value="{{ old('seo_title_en', $blog->seo_title_en) }}">
        </div>

        <div class="form-group">
            <label>Meta Description FR</label>
            <input type="text" name="meta_desc_fr" value="{{ old('meta_desc_fr', $blog->meta_desc_fr) }}">
        </div>

        <div class="form-group">
            <label>Meta Description EN</label>
            <input type="text" name="meta_desc_en" value="{{ old('meta_desc_en', $blog->meta_desc_en) }}">
        </div>

        <button type="submit" class="submit"><i class="fas fa-edit"></i> Modifier</button>
    </form>

@endsection