@extends('layouts.app')

@section('title', __t('Trainings'))

@section('content')

    <h2 class="title">{{ __t('Trainings') }}</h2>

    <a href="{{ route('formations.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __t('Add Training') }}
    </a>

    <input type="text" class="live-search" data-table="formations" placeholder="{{ __t('Search training...') }}" style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
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
                    <th>{{ __t('Image') }}</th>
                    <th>{{ __t('Category') }}</th>
                    <th>{{ __t('Title FR') }}</th>
                    <th>{{ __t('Title EN') }}</th>
                    <th>{{ __t('Duration') }}</th>
                    <th>{{ __t('Price') }}</th>
                    <th>{{ __t('Level') }}</th>
                    <th>{{ __t('Status') }}</th>
                    <th style="width:150px;">{{ __t('Actions') }}</th>
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
                        <td>{{ format_price($f->price) }}</td>
                        <td>{{ get_level_label($f->level) }}</td>
                        <td>
                            <button class="status-toggle badge badge-{{ $f->status->color() }}" data-id="{{ $f->id }}"
                                data-table="formations" style="cursor:pointer; border:none;">
                                {{ $f->status->label() }}
                            </button>
                        </td>
                        <td class="actions">
                            <a href="{{ route('formations.edit', $f->id) }}" class="btn edit">
                                <i class="fas fa-edit"></i> {{ __t('Edit') }}
                            </a>
                            <button class="btn delete" data-id="{{ $f->id }}" data-table="formations">
                                <i class="fas fa-trash"></i> {{ __t('Delete') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="10" style="text-align:center; padding:30px; color:var(--muted);">
                            {{ __t('No trainings found') }}
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