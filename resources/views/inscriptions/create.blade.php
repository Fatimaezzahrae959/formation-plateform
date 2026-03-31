@extends('layouts.app')

@section('title', 'Ajouter Inscription')

@section('content')

    <h2 class="title">Ajouter Inscription</h2>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inscriptions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Participant</label>
            <select name="user_id" required>
                <option value="">-- Choisir Participant --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} — {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Session</label>
            <select name="session_id" required>
                <option value="">-- Choisir Session --</option>
                @foreach($sessions as $session)
                    <option value="{{ $session->id }}" {{ old('session_id') == $session->id ? 'selected' : '' }}>
                        {{ $session->title_fr }} — {{ $session->formation?->title_fr ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
            </select>
        </div>

        <div class="form-group">
            <label>Note</label>
            <textarea name="note">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="submit"><i class="fas fa-plus"></i> Ajouter</button>
    </form>

@endsection