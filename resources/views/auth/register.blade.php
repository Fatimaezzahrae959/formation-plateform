@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')

    <div class="auth-title">Créer un compte</div>
    <div class="auth-subtitle">Rejoignez FormationPro dès maintenant</div>

    @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="form-group">
            <label>Nom complet</label>
            <div class="input-wrap">
                <i class="fas fa-user"></i>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Votre nom" required>
            </div>
            @error('name') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            </div>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Téléphone</label>
            <div class="input-wrap">
                <i class="fas fa-phone"></i>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+212 6xx xxx xxx">
            </div>
            @error('phone') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Rôle</label>
            <div class="input-wrap">
                <i class="fas fa-user-tag"></i>
                <input type="text" style="padding-left: 38px;" name="role" value="participant" hidden>
                <select name="role"
                    style="padding-left: 38px; width:100%; padding:11px 13px 11px 38px; background:var(--surface); border:1px solid var(--border); border-radius:9px; color:var(--text); font-size:14px; font-family:'Inter',sans-serif; outline:none;">
                    <option value="formateur" {{ old('role') == 'formateur' ? 'selected' : '' }}>Formateur</option>
                    <option value="participant" {{ old('role', 'participant') == 'participant' ? 'selected' : '' }}>
                        Participant</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            @error('role') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            @error('password') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Confirmer mot de passe</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>
        </div>

        <button type="submit">
            <i class="fas fa-user-plus"></i> S'inscrire
        </button>
    </form>

@endsection

@section('auth-links')
    Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
@endsection