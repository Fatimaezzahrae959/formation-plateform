@extends('layouts.app')

@section('title', 'Ajouter Session')

@section('content')

    <h2 class="title">Ajouter Session</h2>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sessions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Titre FR</label>
            <input type="text" name="title_fr" value="{{ old('title_fr') }}" required>
        </div>

        <div class="form-group">
            <label>Titre EN</label>
            <input type="text" name="title_en" value="{{ old('title_en') }}" required>
        </div>

        <div class="form-group">
            <label>Formation</label>
            <select name="formation_id" required>
                <option value="">-- Choisir Formation --</option>
                @foreach($formations as $formation)
                    <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                        {{ $formation->title_fr }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Formateur</label>
            <select name="formateur_id" required>
                <option value="">-- Choisir Formateur --</option>
                @foreach($formateurs as $formateur)
                    <option value="{{ $formateur->id }}" {{ old('formateur_id') == $formateur->id ? 'selected' : '' }}>
                        {{ $formateur->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Date de début</label>
            <input type="date" name="start_date" value="{{ old('start_date') }}" required>
        </div>

        <div class="form-group">
            <label>Date de fin</label>
            <input type="date" name="end_date" value="{{ old('end_date') }}" required>
        </div>

        <div class="form-group">
            <label>Capacité</label>
            <input type="number" name="capacity" value="{{ old('capacity', 1) }}" required>
        </div>

        <div class="form-group">
            <label>Mode</label>
            <select name="mode" required>
                <option value="">-- Choisir Mode --</option>
                <option value="présentiel" {{ old('mode') == 'présentiel' ? 'selected' : '' }}>Présentiel</option>
                <option value="en ligne" {{ old('mode') == 'en ligne' ? 'selected' : '' }}>En ligne</option>
                <option value="hybride" {{ old('mode') == 'hybride' ? 'selected' : '' }}>Hybride</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ville</label>
            <input type="text" name="city" value="{{ old('city') }}">
        </div>

        <div class="form-group">
            <label>Lien de réunion (si en ligne)</label>
            <input type="url" name="meeting_link" value="{{ old('meeting_link') }}">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="submit"><i class="fas fa-plus"></i> Ajouter</button>
    </form>

@endsection