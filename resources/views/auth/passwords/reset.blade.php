@extends('layouts.auth')

@section('title', 'Réinitialisation')

@section('content')

    <div class="auth-title">Nouveau mot de passe</div>
    <div class="auth-subtitle">Entrez votre nouveau mot de passe</div>

    @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label>Nouveau mot de passe</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" required>
            </div>
        </div>

        <div class="form-group">
            <label>Confirmer mot de passe</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password_confirmation" required>
            </div>
        </div>

        <button type="submit">
            <i class="fas fa-save"></i> Réinitialiser
        </button>
    </form>

@endsection

@section('auth-links')
    <a href="{{ route('login') }}">Retour à la connexion</a>
@endsection