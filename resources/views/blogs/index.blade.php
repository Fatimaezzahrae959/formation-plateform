@extends('layouts.app')

@section('title', 'Liste des Articles')

@section('content')

    <h2 class="title">Liste des Articles</h2>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('blogs.create') }}" class="btn-add"><i class="fas fa-plus"></i> Ajouter Article</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Titre FR</th>
                <th>Titre EN</th>
                <th>Catégorie</th>
                <th>Auteur</th>
                <th>Statut</th>
                <th>Publié le</th>
                <th style="width:150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
                <tr>
                    <td>{{ $blog->id }}</td>
                    <td>
                        @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}"
                                style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $blog->title_fr }}</td>
                    <td>{{ $blog->title_en }}</td>
                    <td>{{ $blog->category?->name_fr ?? '-' }}</td>
                    <td>{{ $blog->auteur?->name ?? '-' }}</td>
                    <td>{{ $blog->status }}</td>
                    <td>{{ $blog->published_at ?? '-' }}</td>
                    <td class="actions">
                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;"
                            onsubmit="return confirm('Supprimer cet article ?');">
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
        {{ $blogs->links() }}
    </div>

@endsection