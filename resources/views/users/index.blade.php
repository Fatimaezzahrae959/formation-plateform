@extends('layouts.app')

@section('title', 'Liste des Utilisateurs')

@section('content')

    <h2 class="title">Liste des Utilisateurs</h2>

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter Utilisateur
    </a>

    <input type="text" class="live-search" data-table="users" placeholder="🔍 Rechercher utilisateur..." style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                                      border:1px solid var(--border); background:var(--bg);
                                      color:var(--text); font-size:14px; outline:none; display:block;">

    <div class="table-wrap">
        <table id="users-table">
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
                @forelse($users as $user)
                    <tr id="row-{{ $user->id }}">
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            @if(in_array($user->role, ['admin', 'super_admin']))
                                <span class="badge badge-warning">{{ $user->role }}</span>
                            @elseif($user->role === 'formateur')
                                <span class="badge badge-success">Formateur</span>
                            @else
                                <span class="badge badge-info">Participant</span>
                            @endif
                        </td>
                        <td>{{ $user->language }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="badge badge-success">Oui</span>
                            @else
                                <span class="badge badge-danger">Non</span>
                            @endif
                        </td>
                        <td class="actions">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn delete" data-id="{{ $user->id }}" data-table="users">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center; padding:30px; color:var(--muted);">
                            Aucun utilisateur trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:15px;">
        {{ $users->links() }}
    </div>

@endsection