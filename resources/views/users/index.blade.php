@extends('layouts.app')

@section('title', __t('Users'))

@section('content')

    <h2 class="title">{{ __t('Users') }}</h2>

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('users.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __t('Add User') }}
    </a>

    <input type="text" class="live-search" data-table="users" placeholder="{{ __t('Search user...') }}" style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                                          border:1px solid var(--border); background:var(--bg);
                                          color:var(--text); font-size:14px; outline:none; display:block;">

    <div class="table-wrap">
        <table id="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __t('Name') }}</th>
                    <th>{{ __t('Email') }}</th>
                    <th>{{ __t('Phone') }}</th>
                    <th>{{ __t('Role') }}</th>
                    <th>{{ __t('Language') }}</th>
                    <th>{{ __t('Active') }}</th>
                    <th style="width:150px;">{{ __t('Actions') }}</th>
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
                            @if($user->role === 'super_admin')
                                <span class="badge badge-danger">{{ __t('Super Administrator') }}</span>
                            @elseif($user->role === 'admin')
                                <span class="badge badge-warning">{{ __t('Administrator') }}</span>
                            @elseif($user->role === 'formateur')
                                <span class="badge badge-danger">{{ __t('Trainer') }}</span>
                            @else
                                <span class="badge badge-success">{{ __t('Participant') }}</span>
                            @endif
                        </td>
                        <td>{{ strtoupper($user->language ?? 'FR') }}</td>
                        <td>
                            <button class="status-toggle badge badge-{{ $user->is_active ? 'success' : 'danger' }}"
                                data-id="{{ $user->id }}" data-table="users" style="cursor:pointer; border:none;">
                                {{ $user->is_active ? __t('Active') : __t('Inactive') }}
                            </button>
                        </td>
                        <td class="actions">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn edit">
                                <i class="fas fa-edit"></i> {{ __t('Edit') }}
                            </a>
                            <button class="btn delete" data-id="{{ $user->id }}" data-table="users">
                                <i class="fas fa-trash"></i> {{ __t('Delete') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="8" style="text-align:center; padding:30px; color:var(--muted);">
                            {{ __t('No users found') }}
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