@extends('layouts.app')

@section('title', __t('Sessions'))

@section('content')

    <h2 class="title">{{ __t('Sessions') }}</h2>

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('sessions.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __t('Add Session') }}
    </a>

    <input type="text" class="live-search" data-table="sessions" placeholder="{{ __t('Search session...') }}" style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                                      border:1px solid var(--border); background:var(--bg);
                                      color:var(--text); font-size:14px; outline:none; display:block;">
    <table id="sessions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __t('Title FR') }}</th>
                <th>{{ __t('Title EN') }}</th>
                <th>{{ __t('Training') }}</th>
                <th>{{ __t('Trainer') }}</th>
                <th>{{ __t('Start') }}</th>
                <th>{{ __t('End') }}</th>
                <th>{{ __t('Capacity') }}</th>
                <th>{{ __t('Mode') }}</th>
                <th>{{ __t('City') }}</th>
                <th>{{ __t('Link') }}</th>
                <th>{{ __t('Status') }}</th>
                <th style="width:150px;">{{ __t('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessions as $session)
                <tr id="row-{{ $session->id }}">
                    <td>{{ $session->id }}</td>
                    <td>{{ $session->title_fr }}</td>
                    <td>{{ $session->title_en }}</td>
                    <td>{{ $session->formation?->title_fr ?? '-' }}</td>
                    <td>{{ $session->formateur?->name ?? '-' }}</td>
                    <td>{{ $session->start_date }}</td>
                    <td>{{ $session->end_date }}</td>
                    <td>{{ $session->capacity }}</td>
                    <td>{{ $session->mode }}</td>
                    <td>{{ $session->city ?? '-' }}</td>
                    <td>
                        @if($session->meeting_link)
                            <a href="{{ $session->meeting_link }}" target="_blank"
                                style="color:var(--accent);">{{ __t('Link') }}</a>
                        @else
                            <span style="color:var(--muted);">-</span>
                        @endif
                    </td>
                    <td>
                        <button class="status-toggle badge badge-{{ $session->status->color() }}" data-id="{{ $session->id }}"
                            data-table="sessions" style="cursor:pointer; border:none;">
                            {{ $session->status->label() }}
                        </button>
                    </td>
                    <td class="actions">
                        <a href="{{ route('sessions.edit', $session->id) }}" class="btn edit">
                            <i class="fas fa-edit"></i> {{ __t('Edit') }}
                        </a>
                        <button class="btn delete" data-id="{{ $session->id }}" data-table="sessions">
                            <i class="fas fa-trash"></i> {{ __t('Delete') }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr id="empty-row">
                    <td colspan="13" style="text-align:center; padding:30px; color:var(--muted);">
                        {{ __t('No sessions found') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    </div>

    <div style="margin-top:15px;">
        {{ $sessions->links() }}
    </div>

@endsection