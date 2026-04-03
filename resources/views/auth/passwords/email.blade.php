@extends('layouts.auth')

@section('title', 'Mot de passe oublié')

@section('content')

    <div class="auth-title">Mot de passe oublié</div>
    <div class="auth-subtitle">Entrez votre email pour recevoir un lien de réinitialisation</div>

    @if(session('status'))
        <div class="alert-success" style="background:#d4edda;color:#155724;padding:12px;border-radius:8px;margin-bottom:20px;">
            {{ session('status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label>Email</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
            </div>
            @error('email') <span class="error">{{ $message }}</span> @enderror
        </div>

        <button type="submit">
            <i class="fas fa-paper-plane"></i> Envoyer le lien
        </button>
    </form>

@endsection

@section('auth-links')
    <a href="{{ route('login') }}">Retour à la connexion</a>
@endsection