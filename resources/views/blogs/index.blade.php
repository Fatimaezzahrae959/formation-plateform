@extends('layouts.app')

@section('title', 'Liste des Articles')

@section('content')

    <h2 class="title">Liste des Articles</h2>

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('blogs.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter Article
    </a>

    <input type="text" class="live-search" data-table="blogs" placeholder="🔍 Rechercher article..." style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                      border:1px solid var(--border); background:var(--bg);
                      color:var(--text); font-size:14px; outline:none; display:block;">

    <div class="table-wrap">
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
                @forelse($blogs as $blog)
                    <tr id="row-{{ $blog->id }}">
                        <td>{{ $blog->id }}</td>
                        <td>
                            @if($blog->image)
                                <img src="{{ asset('storage/' . $blog->image) }}"
                                    style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                            @else
                                <span style="color:var(--muted);">-</span>
                            @endif
                        </td>
                        <td>{{ $blog->title_fr }}</td>
                        <td>{{ $blog->title_en }}</td>
                        <td>{{ $blog->category?->name_fr ?? '-' }}</td>
                        <td>{{ $blog->auteur?->name ?? '-' }}</td>
                        <td>
                            <button class="status-toggle badge badge-{{ $blog->status->color() }}" data-id="{{ $blog->id }}"
                                data-table="blogs" style="cursor:pointer; border:none;">
                                {{ $blog->status->label() }}
                            </button>
                        </td>
                        <td>{{ $blog->published_at ?? '-' }}</td>
                        <td class="actions">
                            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn delete" data-id="{{ $blog->id }}" data-table="blogs">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="9" style="text-align:center; padding:30px; color:var(--muted);">
                            Aucun article trouvé
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:15px;">
        {{ $blogs->links() }}
    </div>

@endsection