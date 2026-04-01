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

    <table>
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
            @foreach($sessions as $session)
                <tr>
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
                        <span class="badge badge-{{ $session->status->color() }}">
                            {{ $session->status->label() }}
                        </span>
                    </td>
                    <td class="actions">
                        <a href="{{ route('sessions.edit', $session->id) }}" class="btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Supprimer cette session ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:15px;">
        {{ $sessions->links() }}
    </div>

@endsection