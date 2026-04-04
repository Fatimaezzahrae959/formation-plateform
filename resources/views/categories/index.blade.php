@extends('layouts.app')
@section('title', __t('Categories'))

@section('content')

    <h2 class="title">{{ __t('Categories') }}</h2>

    <a href="{{ route('categories.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> {{ __t('Add Category') }}
    </a>

    <input type="text" class="live-search" data-table="categories" placeholder="{{ __t('Search category...') }}" style="margin:12px 0 16px; padding:9px 14px; width:300px; border-radius:8px;
                              border:1px solid var(--border); background:var(--bg);
                              color:var(--text); font-size:14px; outline:none; display:block;">

    @if(session('success'))
        <div class="flash success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-wrap">
        <table id="categories-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>{{ __t('Name FR') }}</th>
                    <th>{{ __t('Name EN') }}</th>
                    <th style="width:150px;">{{ __t('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr id="row-{{ $cat->id }}">
                        <td>{{ $cat->id }}</td>
                        <td>{{ $cat->name_fr }}</td>
                        <td>{{ $cat->name_en }}</td>
                        <td class="actions">
                            <a href="{{ route('categories.edit', $cat->id) }}" class="btn edit">
                                <i class="fas fa-edit"></i> {{ __t('Edit') }}
                            </a>
                            <button class="btn delete" data-id="{{ $cat->id }}" data-table="categories">
                                <i class="fas fa-trash"></i> {{ __t('Delete') }}
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="4" style="text-align:center; padding:30px; color:var(--muted);">
                            {{ __t('No categories found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:15px;">{{ $categories->links() }}</div>

@endsection