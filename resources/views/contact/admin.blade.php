@extends('layouts.app')

@section('title', 'Messages Contact')

@section('content')

    <h2 class="title">Messages Contact</h2>

    <table id="contacts-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
                <th style="width:150px;">Actions</th>
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
                            <option value="nouveau" {{ $contact->status == 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                            <option value="lu" {{ $contact->status == 'lu' ? 'selected' : '' }}>Lu</option>
                            <option value="repondu" {{ $contact->status == 'repondu' ? 'selected' : '' }}>Répondu</option>
                        </select>
                    </td>
                    <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                    <td class="actions">
                        <button class="btn delete" data-id="{{ $contact->id }}" data-table="contacts">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align:center; padding:30px; color:var(--muted);">
                        Aucun message reçu
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
                    if (data.success) showFlash('Status mis à jour !');
                });
        }
    </script>

@endsection