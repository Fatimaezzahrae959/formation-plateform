@extends('layouts.app')

@section('title', __t('Contact Messages'))

@section('content')

    <h2 class="title">{{ __t('Contact Messages') }}</h2>

    <table id="contacts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __t('Name') }}</th>
                <th>{{ __t('Email') }}</th>
                <th>{{ __t('Phone') }}</th>
                <th>{{ __t('Subject') }}</th>
                <th>{{ __t('Message') }}</th>
                <th>{{ __t('Status') }}</th>
                <th>{{ __t('Date') }}</th>
                <th style="width:150px;">{{ __t('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr id="row-{{ $contact->id }}">
                    <td>{{ $contact->id }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone ?? '-' }}</td>
                    <td>{{ $contact->subject }}</td>
                    <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ $contact->message }}
                    </td>
                    <td>
                        <select onchange="updateStatus({{ $contact->id }}, this.value)" style="padding:4px 8px; border-radius:6px; border:1px solid var(--border);
                                               background:var(--bg); color:var(--text); font-size:12px; cursor:pointer;">
                            <option value="nouveau" {{ $contact->status == 'nouveau' ? 'selected' : '' }}>{{ __t('New') }}</option>
                            <option value="lu" {{ $contact->status == 'lu' ? 'selected' : '' }}>{{ __t('Read') }}</option>
                            <option value="repondu" {{ $contact->status == 'repondu' ? 'selected' : '' }}>{{ __t('Replied') }}</option>
                        </select>
                    </td>
                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                    <td class="actions">
                        <button class="btn delete" data-id="{{ $contact->id }}" data-table="contacts">
                            <i class="fas fa-trash"></i> {{ __t('Delete') }}
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:30px; color:var(--muted);">
                        {{ __t('No messages received') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:15px;">
        {{ $contacts->links() }}
    </div>

    <script>
        function updateStatus(id, status) {
            fetch(`/admin/contacts/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: status })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) showFlash('{{ __t("Status updated!") }}');
                });
        }
    </script>

@endsection