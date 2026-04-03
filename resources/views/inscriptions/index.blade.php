@extends('layouts.app')

@section('title', 'Liste des Inscriptions')

@section('content')

    <h2 class="title">Liste des Inscriptions</h2>

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('inscriptions.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Ajouter Inscription
    </a>

    <input type="text" class="live-search" data-table="inscriptions" placeholder="🔍 Rechercher inscription..." style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                      border:1px solid var(--border); background:var(--bg);
                      color:var(--text); font-size:14px; outline:none; display:block;">

    <div class="table-wrap">
        <table id="inscriptions-table">
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
                @forelse($inscriptions as $inscription)
                    <tr id="row-{{ $inscription->id }}">
                        <td>{{ $inscription->id }}</td>
                        <td>{{ $inscription->reference }}</td>
                        <td>{{ $inscription->user?->name ?? '-' }}</td>
                        <td>{{ $inscription->session?->title_fr ?? '-' }}</td>
                        <td>
                            <button class="status-toggle badge badge-{{ $inscription->status->color() }}"
                                data-id="{{ $inscription->id }}" data-table="inscriptions" style="cursor:pointer; border:none;">
                                {{ $inscription->status->label() }}
                            </button>
                        </td>
                        <td>{{ $inscription->note ?? '-' }}</td>
                        <td>{{ $inscription->confirmed_at ?? '-' }}</td>
                        <td>{{ $inscription->cancelled_at ?? '-' }}</td>
                        <td class="actions">
                            <a href="{{ route('inscriptions.edit', $inscription->id) }}" class="btn edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn delete" data-id="{{ $inscription->id }}" data-table="inscriptions">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="9" style="text-align:center; padding:30px; color:var(--muted);">
                            Aucune inscription trouvée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:15px;">
        {{ $inscriptions->links() }}
    </div>

@endsection