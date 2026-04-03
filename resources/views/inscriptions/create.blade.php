@extends('layouts.app')

@section('title', 'Ajouter Inscription')

@section('content')

    <h2 class="title">Ajouter Inscription</h2>

    @if($errors->any())
        <div class="alert-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inscriptions.store') }}" method="POST">
        @csrf

        {{-- 1. Participant --}}
        <div class="form-group">
            <label>Participant</label>
            <select name="user_id" required>
                <option value="">-- Choisir Participant --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} — {{ $user->email }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 2. Formation d'abord --}}
        <div class="form-group">
            <label>Formation</label>
            <select id="formation-select" onchange="loadSessions(this.value)">
                <option value="">-- Choisir Formation --</option>
                @foreach($formations as $formation)
                    <option value="{{ $formation->id }}">
                        {{ $formation->title_fr }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 3. Session — chargée dynamiquement --}}
        <div class="form-group">
            <label>Session</label>
            <select name="session_id" id="session-select" required>
                <option value="">-- Choisir Formation d'abord --</option>
            </select>
            <div id="session-info" style="margin-top:8px; font-size:12px;"></div>
        </div>

        {{-- 4. Détails session --}}
        <div id="session-details" style="display:none; background:var(--card); border:1px solid var(--border);
                 border-radius:10px; padding:16px; margin-bottom:20px; font-size:13px;">
            <div style="font-weight:600; margin-bottom:10px; color:var(--accent);">
                <i class="fas fa-info-circle"></i> Détails de la session
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                <div>📅 <span id="detail-dates"></span></div>
                <div>👥 <span id="detail-capacity"></span></div>
                <div>🏢 <span id="detail-mode"></span></div>
                <div>📍 <span id="detail-city"></span></div>
            </div>
        </div>

        {{-- 5. Status --}}
        <div class="form-group">
            <label>Status</label>
            <select name="status" required>
                @foreach(\App\Enums\InscriptionStatus::cases() as $status)
                    <option value="{{ $status->value }}" {{ old('status', 'pending') == $status->value ? 'selected' : '' }}>
                        {{ $status->label() }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 6. Note --}}
        <div class="form-group">
            <label>Note</label>
            <textarea name="note">{{ old('note') }}</textarea>
        </div>

        <button type="submit" class="submit">
            <i class="fas fa-plus"></i> Ajouter
        </button>
    </form>

    <script>
        function loadSessions(formationId) {
            const sessionSelect = document.getElementById('session-select');
            const sessionInfo = document.getElementById('session-info');
            const sessionDetails = document.getElementById('session-details');

            sessionSelect.innerHTML = '<option value="">-- Chargement... --</option>';
            sessionInfo.innerHTML = '';
            sessionDetails.style.display = 'none';

            if (!formationId) {
                sessionSelect.innerHTML = '<option value="">-- Choisir Formation d\'abord --</option>';
                return;
            }

            fetch(`/ajax/formations/${formationId}/sessions`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(sessions => {
                    sessionSelect.innerHTML = '<option value="">-- Choisir Session --</option>';

                    if (sessions.length === 0) {
                        sessionSelect.innerHTML = '<option value="">Aucune session disponible</option>';
                        sessionInfo.innerHTML = '<span style="color:var(--danger);">⚠️ Aucune session active pour cette formation</span>';
                        return;
                    }

                    sessions.forEach(session => {
                        const option = document.createElement('option');
                        option.value = session.id;
                        option.textContent = `${session.title_fr} (${session.start_date} → ${session.end_date})`;
                        option.dataset.startDate = session.start_date;
                        option.dataset.endDate = session.end_date;
                        option.dataset.capacity = session.capacity;
                        option.dataset.mode = session.mode;
                        option.dataset.city = session.city ?? '-';
                        sessionSelect.appendChild(option);
                    });

                    sessionInfo.innerHTML = `<span style="color:var(--success);">✅ ${sessions.length} session(s) disponible(s)</span>`;
                })
                .catch(() => {
                    sessionSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    sessionInfo.innerHTML = '<span style="color:var(--danger);">❌ Erreur lors du chargement</span>';
                });
        }

        // Afficher détails session
        document.getElementById('session-select').addEventListener('change', function () {
            const selected = this.options[this.selectedIndex];
            const sessionDetails = document.getElementById('session-details');

            if (!this.value) {
                sessionDetails.style.display = 'none';
                return;
            }

            document.getElementById('detail-dates').textContent = selected.dataset.startDate + ' → ' + selected.dataset.endDate;
            document.getElementById('detail-capacity').textContent = selected.dataset.capacity + ' places';
            document.getElementById('detail-mode').textContent = selected.dataset.mode;
            document.getElementById('detail-city').textContent = selected.dataset.city;
            sessionDetails.style.display = 'block';
        });
    </script>

@endsection