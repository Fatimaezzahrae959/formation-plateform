@extends('layouts.auth')

@section('title', 'Vérification email')

@section('content')

    <div class="auth-title">Vérifiez votre email</div>
    <div class="auth-subtitle">Un lien de vérification a été envoyé à votre adresse email</div>

    @if(session('status'))
        <div class="alert-success" style="background:#d4edda;color:#155724;padding:12px;border-radius:8px;margin-bottom:20px;">
            {{ session('status') }}
        </div>
    @endif

    <div class="info-box" style="background:#e8f4fd;padding:15px;border-radius:8px;margin-bottom:20px;text-align:center;">
        <p>Avant de continuer, veuillez vérifier votre email pour un lien de confirmation.</p>
        <p>Si vous n'avez pas reçu l'email,</p>
    </div>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">
            <i class="fas fa-envelope"></i> Renvoyer l'email de vérification
        </button>
    </form>

@endsection

@section('auth-links')
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se
        déconnecter</a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
@endsection