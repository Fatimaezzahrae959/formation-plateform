@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')

    <h2>Créer un compte</h2>

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="name" placeholder="Nom complet">
        </div>
        @error('name') <div class="error">{{ $message }}</div> @enderror

        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Email">
        </div>

        <div class="input-group">
            <i class="fas fa-phone"></i>
            <input type="text" name="phone" placeholder="Téléphone">
        </div>

        <div class="input-group">
            <i class="fas fa-user-tag"></i> <!-- icon pour role -->
            <select name="role" id="role"
                class="w-full px-10 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                <option value="admin">Admin</option>
                <option value="formateur">Formateur</option>
                <option value="participant" selected>Participant</option>
            </select>
        </div>
        @error('role') <div class="error">{{ $message }}</div> @enderror




        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Mot de passe">
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password_confirmation" placeholder="Confirmer">
        </div>

        <button type="submit">S'inscrire</button>

    </form>

    <div class="link">
        Déjà un compte ?
        <a href="{{ route('login') }}">Se connecter</a>
    </div>

@endsection