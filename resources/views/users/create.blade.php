@extends('layouts.app')

@section('title', 'Ajouter Utilisateur')

@section('content')

    <h2 class="title">Ajouter Utilisateur</h2>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label>Rôle</label>
            <select name="role" required>
                <option value="">-- Choisir Rôle --</option>
                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="formateur" {{ old('role') == 'formateur' ? 'selected' : '' }}>Formateur</option>
                <option value="participant" {{ old('role') == 'participant' ? 'selected' : '' }}>Participant</option>
            </select>
        </div>

        <div class="form-group">
            <label>Langue</label>
            <select name="language" required>
                <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>Français</option>
                <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
            </select>
        </div>

        <div class="form-group">
            <label>Actif</label>
            <select name="is_active" required>
                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Confirmer mot de passe</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit" class="submit"><i class="fas fa-plus"></i> Ajouter</button>
    </form>

@endsection