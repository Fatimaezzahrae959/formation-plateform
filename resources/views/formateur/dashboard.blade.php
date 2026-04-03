@extends('layouts.dashboard')

@section('title', 'Dashboard Formateur')

@section('content')

    {{-- Welcome --}}
    <div class="welcome-card">
        <div>
            <h2>Bonjour, {{ $user->name }} 👋</h2>
            <p>Voici un aperçu de vos sessions de formation.</p>
        </div>
        <div class="welcome-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Sessions</div>
            <div class="stat-value" style="color:var(--accent);">{{ $stats['total_sessions'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sessions Actives</div>
            <div class="stat-value" style="color:var(--success);">{{ $stats['sessions_active'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sessions Inactives</div>
            <div class="stat-value" style="color:var(--danger);">{{ $stats['sessions_inactive'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Inscrits</div>
            <div class="stat-value" style="color:var(--warning);">{{ $stats['total_inscrits'] }}</div>
        </div>
    </div>

    {{-- Sessions --}}
    <div class="section-title">Mes Sessions</div>

    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Formation</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Mode</th>
                <th>Ville</th>
                <th>Capacité</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
                <tr>
                    <td>{{ $session->title_fr }}</td>
                    <td>{{ $session->formation?->title_fr ?? '-' }}</td>
                    <td>{{ $session->start_date }}</td>
                    <td>{{ $session->end_date }}</td>
                    <td>{{ $session->mode }}</td>
                    <td>{{ $session->city ?? '-' }}</td>
                    <td>{{ $session->capacity }}</td>
                    <td>
                        <span class="badge badge-{{ $session->status->color() }}">
                            {{ $session->status->label() }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:30px; color:var(--muted);">
                        Aucune session assignée
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection