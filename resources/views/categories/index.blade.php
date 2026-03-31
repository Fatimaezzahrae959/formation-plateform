@extends('layouts.app')

@section('title', 'Gestion des Catégories')

@section('content')

    <h2 class="title">Gestion des Catégories</h2>

    <a href="{{ route('categories.create') }}" class="btn-add"><i class="fas fa-plus"></i> Ajouter Catégorie</a>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom FR</th>
                <th>Nom EN</th>
                <th style="width:220px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->name_fr }}</td>
                    <td>{{ $cat->name_en }}</td>
                    <td class="actions">
                        <a href="{{ route('categories.edit', $cat->id) }}" class="btn edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
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