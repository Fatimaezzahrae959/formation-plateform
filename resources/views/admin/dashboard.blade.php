@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h2 class="title">Dashboard</h2>

    {{-- STATS CARDS --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:16px; margin-bottom:32px; ">
        <div
            style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:20px; display:flex; flex-direction:column; gap:8px;">
            <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:1px;">Formations
            </div>
            <div style="font-size:32px; font-weight:700; color:var(--accent);">{{ $stats['formations'] }}</div>
            <a href="{{ route('formations.index') }}" style="font-size:12px; color:var(--muted); text-decoration:none;">Voir
                tout →</a>
        </div>

        <div
            style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:20px; display:flex; flex-direction:column; gap:8px;">
            <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:1px;">Catégories
            </div>
            <div style="font-size:32px; font-weight:700; color:var(--accent2);">{{ $stats['categories'] }}</div>
            <a href="{{ route('categories.index') }}" style="font-size:12px; color:var(--muted); text-decoration:none;">Voir
                tout →</a>
        </div>


        <div
            style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:20px; display:flex; flex-direction:column; gap:8px;">
            <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:1px;">Sessions
            </div>
            <div style="font-size:32px; font-weight:700; color:var(--success);">{{ $stats['sessions'] }}</div>
            <a href="{{ route('sessions.index') }}" style="font-size:12px; color:var(--muted); text-decoration:none;">Voir
                tout →</a>
        </div>


        <div
            style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:20px; display:flex; flex-direction:column; gap:8px;">
            <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:1px;">Inscriptions
            </div>
            <div style="font-size:32px; font-weight:700; color:var(--warning);">{{ $stats['inscriptions'] }}</div>
            <a href="{{ route('inscriptions.index') }}"
                style="font-size:12px; color:var(--muted); text-decoration:none;">Voir tout →</a>
        </div>

        <div
            style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:20px; display:flex; flex-direction:column; gap:8px;">
            <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:1px;">Utilisateurs
            </div>
            <div style="font-size:32px; font-weight:700; color:var(--danger);">{{ $stats['users'] }}</div>
            <a href="{{ route('users.index') }}" style="font-size:12px; color:var(--muted); text-decoration:none;">Voir
                tout
                →</a>
        </div>

        <div
            style="background:var(--card); border:1px solid var(--border); border-radius:12px; padding:20px; display:flex; flex-direction:column; gap:8px;">
            <div style="font-size:11px; color:var(--muted); text-transform:uppercase; letter-spacing:1px;">Articles Blog
            </div>
            <div style="font-size:32px; font-weight:700; color:var(--accent);">{{ $stats['blogs'] }}</div>
            <a href="{{ route('blogs.index') }}" style="font-size:12px; color:var(--muted); text-decoration:none;">Voir
                tout
                →</a>
        </div>

    </div>

    {{-- BOTTOM GRID --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

        {{-- Dernières Formations --}}
        <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
            <div
                style="padding:16px 20px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                <span style="font-weight:600; font-size:14px;">Dernières Formations</span>
                <a href="{{ route('formations.index') }}"
                    style="font-size:12px; color:var(--accent); text-decoration:none;">Voir tout</a>
            </div>
            <table style="border-radius:0;">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Catégorie</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestFormations as $f)
                        <tr>
                            <td>{{ $f->title_fr }}</td>
                            <td>{{ $f->category?->name_fr ?? '-' }}</td>
                            <td>
                                <span
                                    style="
                                                                                                                    padding:3px 10px;
                                                                                                                    border-radius:20px;
                                                                                                                    font-size:11px;
                                                                                                                    font-weight:600;
                                                                                                                    background:{{ $f->status == 'publie' ? 'rgba(0,229,160,0.1)' : ($f->status == 'archive' ? 'rgba(255,69,96,0.1)' : 'rgba(255,184,0,0.1)') }};
                                                                                                                    color:{{ $f->status == 'publie' ? 'var(--success)' : ($f->status == 'archive' ? 'var(--danger)' : 'var(--warning)') }};
                                                                                                                ">{{ $f->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Dernières Inscriptions --}}
        <div style="background:var(--card); border:1px solid var(--border); border-radius:12px; overflow:hidden;">
            <div
                style="padding:16px 20px; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
                <span style="font-weight:600; font-size:14px;">Dernières Inscriptions</span>
                <a href="{{ route('inscriptions.index') }}"
                    style="font-size:12px; color:var(--accent); text-decoration:none;">Voir tout</a>
            </div>
            <table style="border-radius:0;">
                <thead>
                    <tr>
                        <th>Participant</th>
                        <th>Session</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestInscriptions as $i)
                        <tr>
                            <td>{{ $i->user?->name ?? '-' }}</td>
                            <td>{{ $i->session?->title_fr ?? '-' }}</td>
                            <td>
                                <span
                                    style="
                                                                                                                    padding:3px 10px;
                                                                                                                    border-radius:20px;
                                                                                                                    font-size:11px;
                                                                                                                    font-weight:600;
                                                                                                                    background:{{ $i->status == 'confirmed' ? 'rgba(0,229,160,0.1)' : ($i->status == 'cancelled' ? 'rgba(255,69,96,0.1)' : 'rgba(255,184,0,0.1)') }};
                                                                                                                    color:{{ $i->status == 'confirmed' ? 'var(--success)' : ($i->status == 'cancelled' ? 'var(--danger)' : 'var(--warning)') }};
                                                                                                                ">{{ $i->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    {{-- في admin dashboard --}}
    <td>
        {{ auth()->user()->last_activity_at
        ? auth()->user()->last_activity_at->diffForHumans()
        : 'Jamais' }}
    </td>

@endsection