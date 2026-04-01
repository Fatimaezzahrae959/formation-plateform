@extends('layouts.app')

@section('title', 'Gestion des Formations')

@section('content')

    <h2 class="title">Gestion des Formations</h2>

    <a href="{{ route('formations.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter Formation
    </a>

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Catégorie</th>
                <th>Titre FR</th>
                <th>Titre EN</th>
                <th>Durée</th>
                <th>Prix</th>
                <th>Niveau</th>
                <th>Status</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($formations as $f)
                <tr>
                    <td>{{ $f->id }}</td>
                    <td>
                        @if($f->image)
                            <img src="{{ asset('storage/' . $f->image) }}"
                                style="width:45px;height:45px;object-fit:cover;border-radius:6px;">
                        @else
                            <span style="color:var(--muted);">-</span>
                        @endif
                    </td>
                    <td>{{ $f->category?->name_fr ?? '-' }}</td>
                    <td>{{ $f->title_fr }}</td>
                    <td>{{ $f->title_en }}</td>
                    <td>{{ $f->duration ?? '-' }}</td>
                    <td>{{ $f->price }} MAD</td>
                    <td>{{ $f->level ?? '-' }}</td>
                    <td>
                        <span class="badge badge-{{ $f->status->color() }}">
                            {{ $f->status->label() }}
                        </span>
                    </td>
                    <td class="actions">
                        <a href="{{ route('formations.edit', $f->id) }}" class="btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('formations.destroy', $f->id) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Supprimer cette formation ?');">
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
        {{ $formations->links() }}
    </div>

@endsection