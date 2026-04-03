@extends('layouts.app')

@section('title', 'Gestion des Formations')

@section('content')

    <h2 class="title">Gestion des Formations</h2>

    <a href="{{ route('formations.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter Formation
    </a>

    <input type="text" class="live-search" data-table="formations" placeholder="🔍 Rechercher formation..." style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                                              border:1px solid var(--border); background:var(--bg);
                                              color:var(--text); font-size:14px; outline:none; display:block;">

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table id="formations-table">
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
                @forelse($formations as $f)
                    <tr id="row-{{ $f->id }}">
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
                        <td>{{ truncate_text($f->title_fr, 30) }}</td>
                        <td>{{ truncate_text($f->title_en, 30) }}</td>
                        <td>{{ $f->duration ?? '-' }}</td>
                        <td>{{ format_price($f->price) }}</td> {{-- Helper utilisé --}}
                        <td>{{ get_level_label($f->level) }}</td> {{-- Helper utilisé --}}
                        <td>
                            <button class="status-toggle badge badge-{{ $f->status->color() }}" data-id="{{ $f->id }}"
                                data-table="formations" style="cursor:pointer; border:none;">
                                {{ $f->status->label() }}
                            </button> {{-- Helper utilisé --}}
                        </td>
                        <td class="actions">
                            <a href="{{ route('formations.edit', $f->id) }}" class="btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn delete" data-id="{{ $f->id }}" data-table="formations">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="10" style="text-align:center; padding:30px; color:var(--muted);">
                            Aucune formation trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:15px;">
        {{ $formations->links() }}
    </div>

@endsection