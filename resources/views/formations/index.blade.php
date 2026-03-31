@extends('layouts.app')

@section('title', 'Gestion des Formations')

@section('content')

    <h2 class="title">Gestion des Formations</h2>

    <a href="{{ route('formations.create') }}" class="btn-add"><i class="fas fa-plus"></i> Ajouter Formation</a>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
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
                <th style="width:250px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($formations as $f)
                <tr>
                    <td>{{ $f->id }}</td>
                    <td>
                        @if($f->image)
                            <img src="{{ asset('storage/' . $f->image) }}" alt="image"
                                style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td>{{ $f->category?->name_fr ?? '-' }}</td>
                    <td>{{ $f->title_fr }}</td>
                    <td>{{ $f->title_en }}</td>
                    <td>{{ $f->duration }}</td>
                    <td>{{ $f->price }} MAD</td>
                    <td>{{ $f->level ?? '-' }}</td>
                    <td>{{ $f->status }}</td>
                    <td class="actions">
                        <a href="{{ route('formations.edit', $f->id) }}" class="btn edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('formations.destroy', $f->id) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn delete"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection