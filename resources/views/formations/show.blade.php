@extends('layouts.app')

@section('title', $formation->title_fr . ' — FormationPro')

@section('content')

    <style>
        .show-container {
            max-width: 900px;
        }

        .show-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: rgba(108, 99, 255, 0.1);
            color: var(--accent);
            border: 1px solid rgba(108, 99, 255, 0.3);
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 24px;
            transition: all 0.2s;
        }

        .show-back:hover {
            background: var(--accent);
            color: white;
        }

        .show-header {
            margin-bottom: 28px;
        }

        .show-header h1 {
            font-family: 'Space Mono', monospace;
            font-size: 26px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 6px;
        }

        .show-header h4 {
            color: var(--muted);
            font-weight: 400;
            font-size: 16px;
        }

        .show-image {
            width: 100%;
            max-height: 380px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 28px;
            border: 1px solid var(--border);
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            background: var(--card);
            border: 1px solid var(--border);
            padding: 22px;
            border-radius: 12px;
            margin-bottom: 28px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .detail-item strong {
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .detail-item span {
            font-size: 14px;
            color: var(--text);
            font-weight: 500;
        }

        .detail-item .price {
            font-size: 20px;
            font-weight: 700;
            color: var(--success);
        }

        .show-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 22px;
        }

        .show-section h3 {
            font-family: 'Space Mono', monospace;
            font-size: 14px;
            color: var(--accent);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .show-section p {
            color: var(--text);
            line-height: 1.7;
            font-size: 14px;
        }

        .show-section hr {
            border: none;
            border-top: 1px solid var(--border);
            margin: 14px 0;
        }

        .show-section em {
            color: var(--muted);
        }

        .seo-info {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 22px;
        }

        .seo-info h3 {
            font-family: 'Space Mono', monospace;
            font-size: 13px;
            color: var(--warning);
            margin-bottom: 14px;
        }

        .seo-info p {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .seo-info strong {
            color: var(--text);
        }

        .seo-info code {
            background: var(--bg);
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: var(--accent2);
        }

        .sessions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-top: 16px;
        }

        .session-card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 18px;
            transition: border-color 0.2s;
        }

        .session-card:hover {
            border-color: var(--accent);
        }

        .session-card-row {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text);
            margin-bottom: 8px;
        }

        .session-card-row i {
            color: var(--accent);
            width: 16px;
        }

        .btn-inscription {
            margin-top: 12px;
            width: 100%;
            padding: 9px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-inscription:hover {
            background: #5a52e0;
        }
    </style>

    <div class="show-container">

        <a href="{{ route('formations.index') }}" class="show-back">
            <i class="fas fa-arrow-left"></i> Retour
        </a>

        {{-- Header --}}
        <div class="show-header">
            <h1>{{ $formation->title_fr }}</h1>
            <h4>{{ $formation->title_en }}</h4>
        </div>

        {{-- Image --}}
        @if($formation->image)
            <img src="{{ asset('storage/' . $formation->image) }}" alt="{{ $formation->title_fr }}" class="show-image">
        @endif

        {{-- Details --}}
        <div class="details-grid">
            <div class="detail-item">
                <strong>Catégorie</strong>
                <span>{{ $formation->category?->name_fr ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <strong>Prix</strong>
                <span class="price">{{ number_format($formation->price, 2) }} MAD</span>
            </div>
            <div class="detail-item">
                <strong>Durée</strong>
                <span>{{ $formation->duration ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <strong>Niveau</strong>
                <span>{{ $formation->level ?? '-' }}</span>
            </div>
            <div class="detail-item">
                <strong>Statut</strong>
                <span>
                    <span class="badge badge-{{ $formation->status->color() }}">
                        {{ $formation->status->label() }}
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <strong>Publié le</strong>
                <span>{{ $formation->published_at ? \Carbon\Carbon::parse($formation->published_at)->format('d/m/Y') : '-' }}</span>
            </div>
        </div>

        {{-- Description courte --}}
        @if($formation->short_desc_fr)
            <div class="show-section">
                <h3><i class="fas fa-align-left"></i> Description courte</h3>
                <p>{{ $formation->short_desc_fr }}</p>
                @if($formation->short_desc_en)
                    <hr>
                    <p><em>{{ $formation->short_desc_en }}</em></p>
                @endif
            </div>
        @endif

        {{-- Description complète --}}
        @if($formation->full_desc_fr)
            <div class="show-section">
                <h3><i class="fas fa-book-open"></i> Description complète</h3>
                <p>{!! nl2br(e($formation->full_desc_fr)) !!}</p>
                @if($formation->full_desc_en)
                    <hr>
                    <p><em>{!! nl2br(e($formation->full_desc_en)) !!}</em></p>
                @endif
            </div>
        @endif

        {{-- SEO info (admin only) --}}
        @auth
            @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                <div class="seo-info">
                    <h3><i class="fas fa-search"></i> Informations SEO</h3>
                    <p><strong>Slug FR:</strong> <code>{{ $formation->slug_fr }}</code></p>
                    <p><strong>Slug EN:</strong> <code>{{ $formation->slug_en }}</code></p>
                    <p><strong>SEO Title FR:</strong> {{ $formation->seo_title_fr ?? 'Non défini' }}</p>
                    <p><strong>SEO Title EN:</strong> {{ $formation->seo_title_en ?? 'Non défini' }}</p>
                    <p><strong>Meta Desc FR:</strong> {{ $formation->meta_desc_fr ?? 'Non défini' }}</p>
                    <p><strong>Meta Desc EN:</strong> {{ $formation->meta_desc_en ?? 'Non défini' }}</p>
                </div>
            @endif
        @endauth

        {{-- Sessions --}}
        @if($formation->sessions && $formation->sessions->count() > 0)
            <div class="show-section">
                <h3><i class="fas fa-calendar-alt"></i> Sessions disponibles ({{ $formation->sessions->count() }})</h3>
                <div class="sessions-grid">
                    @foreach($formation->sessions as $session)
                        <div class="session-card">
                            <div class="session-card-row">
                                <i class="fas fa-tag"></i>
                                <strong>{{ $session->title_fr }}</strong>
                            </div>
                            <div class="session-card-row">
                                <i class="fas fa-calendar"></i>
                                {{ $session->start_date }} → {{ $session->end_date }}
                            </div>
                            <div class="session-card-row">
                                <i class="fas fa-laptop"></i>
                                {{ $session->mode }}
                            </div>
                            <div class="session-card-row">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $session->city ?? 'En ligne' }}
                            </div>
                            <div class="session-card-row">
                                <i class="fas fa-users"></i>
                                {{ $session->capacity }} places
                            </div>
                            <div class="session-card-row">
                                <i class="fas fa-circle"></i>
                                <span class="badge badge-{{ $session->status->color() }}">
                                    {{ $session->status->label() }}
                                </span>
                            </div>
                            @auth
                                <button class="btn-inscription" data-session="{{ $session->id }}">
                                    <i class="fas fa-user-plus"></i> S'inscrire
                                </button>
                            @endauth
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection