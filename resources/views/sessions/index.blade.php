@extends('layouts.app')

@section('title', 'Liste des Sessions')

@section('content')

    <h2 class="title">Liste des Sessions</h2>

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('sessions.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter Session
    </a>

    <input type="text" class="live-search" data-table="sessions" placeholder="🔍 Rechercher session..." style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                              border:1px solid var(--border); background:var(--bg);
                              color:var(--text); font-size:14px; outline:none; display:block;">
    <table id="sessions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre FR</th>
                <th>Titre EN</th>
                <th>Formation</th>
                <th>Formateur</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Capacité</th>
                <th>Mode</th>
                <th>Ville</th>
                <th>Lien</th>
                <th>Statut</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
                <tr id="row-{{ $session->id }}">
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->title_fr }}</td>
                    <td>{{ $session->title_en }}</td>
                    <td>{{ $session->formation?->title_fr ?? '-' }}</td>
                    <td>{{ $session->formateur?->name ?? '-' }}</td>
                    <td>{{ $session->start_date }}</td>
                    <td>{{ $session->end_date }}</td>
                    <td>{{ $session->capacity }}</td>
                    <td>{{ $session->mode }}</td>
                    <td>{{ $session->city ?? '-' }}</td>
                    <td>
                        @if($session->meeting_link)
                            <a href="{{ $session->meeting_link }}" target="_blank" style="color:var(--accent);">Lien</a>
                        @else
                            <span style="color:var(--muted);">-</span>
                        @endif
                    </td>
                    <td>
                        <button class="status-toggle badge badge-{{ $session->status->color() }}" data-id="{{ $session->id }}"
                            data-table="sessions" style="cursor:pointer; border:none;">
                            {{ $session->status->label() }}
                        </button>
                    </td>
                    <td class="actions">
                        <a href="{{ route('sessions.edit', $session->id) }}" class="btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn delete" data-id="{{ $session->id }}" data-table="sessions">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr id="empty-row">
                    <td colspan="13" style="text-align:center; padding:30px; color:var(--muted);">
                        Aucune session trouvée
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div style="margin-top:15px;">
        {{ $sessions->links() }}
    </div>

@endsection