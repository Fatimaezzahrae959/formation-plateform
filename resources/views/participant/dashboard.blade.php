@extends('layouts.dashboard')

@section('title', 'Dashboard Participant')

@section('content')

    {{-- Welcome --}}
    <div class="welcome-card">
        <div>
            <h2>Bonjour, {{ $user->name }} 👋</h2>
            <p>Voici vos inscriptions aux formations.</p>
        </div>
        <div class="welcome-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Inscriptions</div>
            <div class="stat-value" style="color:var(--accent);">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">En attente</div>
            <div class="stat-value" style="color:var(--warning);">{{ $stats['pending'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Confirmées</div>
            <div class="stat-value" style="color:var(--success);">{{ $stats['confirmed'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Annulées</div>
            <div class="stat-value" style="color:var(--danger);">{{ $stats['cancelled'] }}</div>
        </div>
    </div>

    {{-- Inscriptions --}}
    <div class="section-title">Mes Inscriptions</div>

    <table>
        <thead>
            <tr>
                <th>Référence</th>
                <th>Formation</th>
                <th>Session</th>
                <th>Mode</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Statut</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @forelse($inscriptions as $inscription)
                <tr>
                    <td><code style="color:var(--accent2); font-size:12px;">{{ $inscription->reference }}</code></td>
                    <td>{{ $inscription->session?->formation?->title_fr ?? '-' }}</td>
                    <td>{{ $inscription->session?->title_fr ?? '-' }}</td>
                    <td>{{ $inscription->session?->mode ?? '-' }}</td>
                    <td>{{ $inscription->session?->start_date ?? '-' }}</td>
                    <td>{{ $inscription->session?->end_date ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $inscription->status->color() }}">
                            {{ $inscription->status->label() }}
                        </span>
                    </td>
                    <td>{{ $inscription->note ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:30px; color:var(--muted);">
                        Aucune inscription trouvée
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection