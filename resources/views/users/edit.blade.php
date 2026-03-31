@extends('layouts.app')

@section('title', 'Modifier Utilisateur')

@section('content')

    <h2 class="title">Modifier Utilisateur</h2>

    @if($errors->any())
        <div style="color:red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label>Téléphone</label>
            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="form-group">
            <label>Rôle</label>
            <select name="role" required>
                <option value="">-- Choisir Rôle --</option>
                <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin
                </option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="formateur" {{ old('role', $user->role) == 'formateur' ? 'selected' : '' }}>Formateur</option>
                <option value="participant" {{ old('role', $user->role) == 'participant' ? 'selected' : '' }}>Participant
                </option>
            </select>
        </div>

        <div class="form-group">
            <label>Langue</label>
            <select name="language" required>
                <option value="fr" {{ old('language', $user->language) == 'fr' ? 'selected' : '' }}>Français</option>
                <option value="en" {{ old('language', $user->language) == 'en' ? 'selected' : '' }}>English</option>
            </select>
        </div>

        <div class="form-group">
            <label>Actif</label>
            <select name="is_active" required>
                <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>Non</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nouveau mot de passe <small>(laisser vide pour ne pas changer)</small></label>
            <input type="password" name="password">
        </div>

        <div class="form-group">
            <label>Confirmer mot de passe</label>
            <input type="password" name="password_confirmation">
        </div>

        <button type="submit" class="submit"><i class="fas fa-edit"></i> Modifier</button>
    </form>

@endsection