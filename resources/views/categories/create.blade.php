@extends('layouts.app')

@section('title', 'Ajouter Catégorie')

@section('content')

    <h2 class="title">Ajouter Nouvelle Catégorie</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nom FR</label>
            <input type="text" name="name_fr" value="{{ old('name_fr') }}">
            @error('name_fr') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Nom EN</label>
            <input type="text" name="name_en" value="{{ old('name_en') }}">
            @error('name_en') <div class="error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="submit"><i class="fas fa-plus"></i> Ajouter</button>
    </form>

@endsection