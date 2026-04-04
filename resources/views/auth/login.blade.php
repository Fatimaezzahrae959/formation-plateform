@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')

    <div class="auth-title">Connexion</div>
    <div class="auth-subtitle">Bienvenue, connectez-vous à votre compte</div>

    @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            </div>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Mot de passe</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            @error('password') <span class="error">{{ $message }}</span> @enderror

        </div>

        <button type="submit">
            <i class="fas fa-sign-in-alt"></i> Se connecter
        </button>
        <a href="{{ route('password.request') }}" style="font-size: 12px; color: #6b6b6b  ;">
            Mot de passe oublié ?
        </a>
    </form>

@endsection

@section('auth-links')
    Pas encore de compte ? <a href="{{ route('register.show') }}">S'inscrire</a>

@endsection