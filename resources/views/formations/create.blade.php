@extends('layouts.app')

@section('title', 'Ajouter Formation')

@section('content')

    <h2 class="title">Ajouter Formation</h2>

    @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('formations.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>Catégorie</label>
            <select name="category_id">
                <option value="">-- Aucune --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name_fr }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Titre FR</label>
            <input type="text" name="title_fr" value="{{ old('title_fr') }}" required>
            @error('title_fr') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Titre EN</label>
            <input type="text" name="title_en" value="{{ old('title_en') }}" required>
            @error('title_en') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Courte FR</label>
            <textarea name="short_desc_fr">{{ old('short_desc_fr') }}</textarea>
            @error('short_desc_fr') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Courte EN</label>
            <textarea name="short_desc_en">{{ old('short_desc_en') }}</textarea>
            @error('short_desc_en') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Complète FR</label>
            <textarea name="full_desc_fr">{{ old('full_desc_fr') }}</textarea>
            @error('full_desc_fr') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Description Complète EN</label>
            <textarea name="full_desc_en">{{ old('full_desc_en') }}</textarea>
            @error('full_desc_en') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" accept="image/*">
            @error('image') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Durée</label>
            <input type="text" name="duration" value="{{ old('duration') }}">
            @error('duration') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Prix (MAD)</label>
            <input type="number" name="price" value="{{ old('price', 0) }}">
            @error('price') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Niveau</label>
            <input type="text" name="level" value="{{ old('level') }}">
            @error('level') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="brouillon" {{ old('status') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                <option value="publie" {{ old('status') == 'publie' ? 'selected' : '' }}>Publié</option>
                <option value="archive" {{ old('status') == 'archive' ? 'selected' : '' }}>Archivé</option>
            </select>
            @error('status') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="submit"><i class="fas fa-plus"></i> Ajouter</button>
    </form>

@endsection