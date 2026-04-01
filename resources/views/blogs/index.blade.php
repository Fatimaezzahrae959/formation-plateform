@extends('layouts.app')

@section('title', 'Liste des Articles')

@section('content')

    <h2 class="title">Liste des Articles</h2>

    @if(session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    <a href="{{ route('blogs.create') }}" class="btn-add"><i class="fas fa-plus"></i> Ajouter Article</a>

    <input type="text" class="live-search" data-table="blogs" placeholder="Rechercher un article..."
        style="margin:10px 0;padding:5px;width:300px;">

    <table id="blogs-table">
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
                    <td>
                        <button class="status-toggle" data-id="{{ $blog->id }}" data-table="blogs">
                            {{ ucfirst($blog->status) }}
                        </button>
                    </td>
                    <td>{{ $blog->published_at ?? '-' }}</td>
                    <td class="actions">
                        <a href="{{ route('blogs.edit', $blog->id) }}" class="btn edit"><i class="fas fa-edit"></i></a>
                        <button class="btn delete" data-id="{{ $blog->id }}" data-table="blogs"><i
                                class="fas fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:15px;">
        {{ $blogs->links() }}
    </div>

@endsection