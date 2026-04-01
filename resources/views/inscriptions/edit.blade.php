@extends('layouts.app')

@section('title', 'Modifier Inscription')

@section('content')

    <h2 class="title">Modifier Inscription</h2>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inscriptions.update', $inscription->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Participant</label>
            <select name="user_id" required>
                <option value="">-- Choisir Participant --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $inscription->user_id) == $user->id ? 'selected' : '' }}>
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
                    <option value="{{ $session->id }}" {{ old('session_id', $inscription->session_id) == $session->id ? 'selected' : '' }}>
                        {{ $session->title_fr }} — {{ $session->formation?->title_fr ?? '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                @foreach(\App\Enums\InscriptionStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ old('status', $inscription->status->value) == $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Note</label>
            <textarea name="note">{{ old('note', $inscription->note) }}</textarea>
        </div>

        <div class="form-group">
            <label>Référence</label>
            <input type="text" value="{{ $inscription->reference }}" disabled>
        </div>

        <button type="submit" class="submit"><i class="fas fa-edit"></i> Modifier</button>
    </form>

@endsection