@extends('layouts.app')

@section('title', 'Liste des Utilisateurs')

@section('content')

    <h2 class="title">Liste des Utilisateurs</h2>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('users.create') }}" class="btn-add"><i class="fas fa-plus"></i> Ajouter Utilisateur</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Rôle</th>
                <th>Langue</th>
                <th>Actif</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->language }}</td>
                    <td>{{ $user->is_active ? 'Oui' : 'Non' }}</td>
                    <td class="actions">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Supprimer cet utilisateur ?');">
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
        {{ $users->links() }}
    </div>

@endsection