@extends('layouts.app')

@section('title', 'Modifier Catégorie')

@section('content')

    <h2 class="title">Modifier Catégorie</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nom FR</label>
            <input type="text" name="name_fr" value="{{ old('name_fr', $category->name_fr) }}">
            @error('name_fr') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Nom EN</label>
            <input type="text" name="name_en" value="{{ old('name_en', $category->name_en) }}">
            @error('name_en') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="submit"><i class="fas fa-edit"></i> Modifier</button>
    </form>

@endsection