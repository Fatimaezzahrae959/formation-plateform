@extends('layouts.app')

@section('title', 'Modifier Session')

@section('content')

    <h2 class="title">Modifier Session</h2>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sessions.update', $session->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Titre FR</label>
            <input type="text" name="title_fr" value="{{ old('title_fr', $session->title_fr) }}" required>
        </div>

        <div class="form-group">
            <label>Titre EN</label>
            <input type="text" name="title_en" value="{{ old('title_en', $session->title_en) }}" required>
        </div>

        <div class="form-group">
            <label>Formation</label>
            <select name="formation_id" required>
                <option value="">-- Choisir Formation --</option>
                @foreach($formations as $formation)
                    <option value="{{ $formation->id }}" {{ old('formation_id', $session->formation_id) == $formation->id ? 'selected' : '' }}>
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
                    <option value="{{ $formateur->id }}" {{ old('formateur_id', $session->formateur_id) == $formateur->id ? 'selected' : '' }}>
                        {{ $formateur->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Date de début</label>
            <input type="date" name="start_date" value="{{ old('start_date', $session->start_date) }}" required>
        </div>

        <div class="form-group">
            <label>Date de fin</label>
            <input type="date" name="end_date" value="{{ old('end_date', $session->end_date) }}" required>
        </div>

        <div class="form-group">
            <label>Capacité</label>
            <input type="number" name="capacity" value="{{ old('capacity', $session->capacity) }}" required>
        </div>

        <div class="form-group">
            <label>Mode</label>
            <select name="mode" required>
                <option value="">-- Choisir Mode --</option>
                <option value="présentiel" {{ old('mode', $session->mode) == 'présentiel' ? 'selected' : '' }}>Présentiel
                </option>
                <option value="en ligne" {{ old('mode', $session->mode) == 'en ligne' ? 'selected' : '' }}>En ligne</option>
                <option value="hybride" {{ old('mode', $session->mode) == 'hybride' ? 'selected' : '' }}>Hybride</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ville</label>
            <input type="text" name="city" value="{{ old('city', $session->city) }}">
        </div>

        <div class="form-group">
            <label>Lien de réunion (si en ligne)</label>
            <input type="url" name="meeting_link" value="{{ old('meeting_link', $session->meeting_link) }}">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                @foreach(\App\Enums\SessionStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ old('status', $session->status->value) == $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="submit"><i class="fas fa-edit"></i> Modifier</button>
    </form>

@endsection