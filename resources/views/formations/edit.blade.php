@extends('layouts.app')

@section('title', 'Modifier Formation')

@section('content')

    <h2 class="title">Modifier Formation</h2>

    @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('formations.update', $formation->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Catégorie</label>
            <select name="category_id">
                <option value="">-- Aucune --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $formation->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name_fr }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Titre FR</label>
            <input type="text" name="title_fr" value="{{ old('title_fr', $formation->title_fr) }}" required>
            @error('title_fr') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Titre EN</label>
            <input type="text" name="title_en" value="{{ old('title_en', $formation->title_en) }}" required>
            @error('title_en') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Courte FR</label>
            <textarea name="short_desc_fr">{{ old('short_desc_fr', $formation->short_desc_fr) }}</textarea>
            @error('short_desc_fr') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Courte EN</label>
            <textarea name="short_desc_en">{{ old('short_desc_en', $formation->short_desc_en) }}</textarea>
            @error('short_desc_en') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Complète FR</label>
            <textarea name="full_desc_fr">{{ old('full_desc_fr', $formation->full_desc_fr) }}</textarea>
            @error('full_desc_fr') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Complète EN</label>
            <textarea name="full_desc_en">{{ old('full_desc_en', $formation->full_desc_en) }}</textarea>
            @error('full_desc_en') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Image actuelle</label><br>
            @if($formation->image)
                <img src="{{ asset('storage/' . $formation->image) }}" alt="image" style="width:80px;height:80px;object-fit:cover;border-radius:6px;margin-bottom:8px;">
            @else
                <span>Aucune image</span>
            @endif
            <label style="margin-top:8px;">Changer l'image</label>
            <input type="file" name="image" accept="image/*">
            @error('image') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Durée</label>
            <input type="text" name="duration" value="{{ old('duration', $formation->duration) }}">
            @error('duration') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Prix (MAD)</label>
            <input type="number" name="price" value="{{ old('price', $formation->price) }}">
            @error('price') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Niveau</label>
            <input type="text" name="level" value="{{ old('level', $formation->level) }}">
            @error('level') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="brouillon" {{ old('status', $formation->status) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                <option value="publie" {{ old('status', $formation->status) == 'publie' ? 'selected' : '' }}>Publié</option>
                <option value="archive" {{ old('status', $formation->status) == 'archive' ? 'selected' : '' }}>Archivé</option>
            </select>
            @error('status') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="submit"><i class="fas fa-edit"></i> Modifier</button>
    </form>

@endsection