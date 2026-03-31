@extends('layouts.app')

@section('title', 'Liste des Inscriptions')

@section('content')

    <h2 class="title">Liste des Inscriptions</h2>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('inscriptions.create') }}" class="btn-add"><i class="fas fa-plus"></i> Ajouter Inscription</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Référence</th>
                <th>Participant</th>
                <th>Session</th>
                <th>Status</th>
                <th>Note</th>
                <th>Confirmé le</th>
                <th>Annulé le</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inscriptions as $inscription)
                <tr>
                    <td>{{ $inscription->id }}</td>
                    <td>{{ $inscription->reference }}</td>
                    <td>{{ $inscription->user?->name ?? '-' }}</td>
                    <td>{{ $inscription->session?->title_fr ?? '-' }}</td>
                    <td>{{ $inscription->status }}</td>
                    <td>{{ $inscription->note ?? '-' }}</td>
                    <td>{{ $inscription->confirmed_at ?? '-' }}</td>
                    <td>{{ $inscription->cancelled_at ?? '-' }}</td>
                    <td class="actions">
                        <a href="{{ route('inscriptions.edit', $inscription->id) }}" class="btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('inscriptions.destroy', $inscription->id) }}" method="POST"
                            style="display:inline-block;" onsubmit="return confirm('Supprimer cette inscription ?');">
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
        {{ $inscriptions->links() }}
    </div>

@endsection