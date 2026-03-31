@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')

    <h2>Connexion</h2>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email">
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Mot de passe">
        </div>

        <button type="submit">Se connecter</button>

    </form>

    <div class="link">
        Pas encore de compte ?
        <a href="{{ route('register.show') }}">S'inscrire</a>
    </div>

@endsection