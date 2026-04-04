@extends('layouts.app')

@section('title', __t('Dashboard'))

@section('content')

    <div class="dashboard-container">
        <h2 class="title">{{ __t('Dashboard') }}</h2>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-book-open"></i></div>
                <div class="stat-number">{{ $stats['formations'] }}</div>
                <div class="stat-label">{{ __t('Formations') }}</div>
                <a href="{{ route('formations.index') }}" class="stat-link">{{ __t('View all') }} →</a>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-tags"></i></div>
                <div class="stat-number">{{ $stats['categories'] }}</div>
                <div class="stat-label">{{ __t('Categories') }}</div>
                <a href="{{ route('categories.index') }}" class="stat-link">{{ __t('View all') }} →</a>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-number">{{ $stats['sessions'] }}</div>
                <div class="stat-label">{{ __t('Sessions') }}</div>
                <a href="{{ route('sessions.index') }}" class="stat-link">{{ __t('View all') }} →</a>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-number">{{ $stats['inscriptions'] }}</div>
                <div class="stat-label">{{ __t('Registrations') }}</div>
                <a href="{{ route('inscriptions.index') }}" class="stat-link">{{ __t('View all') }} →</a>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number">{{ $stats['users'] }}</div>
                <div class="stat-label">{{ __t('Users') }}</div>
                <a href="{{ route('users.index') }}" class="stat-link">{{ __t('View all') }} →</a>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-blog"></i></div>
                <div class="stat-number">{{ $stats['blogs'] }}</div>
                <div class="stat-label">{{ __t('Blog') }}</div>
                <a href="{{ route('blogs.index') }}" class="stat-link">{{ __t('View all') }} →</a>
            </div>
        </div>

        <div class="dashboard-section">
            <div class="section-header">
                <h3>{{ __t('Latest Trainings') }}</h3>
                <a href="{{ route('formations.index') }}" class="section-link">{{ __t('View all') }} →</a>
            </div>
            <div class="table-wrap">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>{{ __t('Title') }}</th>
                            <th>{{ __t('Category') }}</th>
                            <th>{{ __t('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestFormations as $formation)
                            <tr>
                                <td>{{ $formation->title_fr }}</td>
                                <td>{{ $formation->category?->name_fr ?? '-' }}</td>
                                <td><span
                                        class="badge badge-{{ $formation->status->color() }}">{{ $formation->status->label() }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="dashboard-section">
            <div class="section-header">
                <h3>{{ __t('Latest Registrations') }}</h3>
                <a href="{{ route('inscriptions.index') }}" class="section-link">{{ __t('View all') }} →</a>
            </div>
            <div class="table-wrap">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>{{ __t('Participant') }}</th>
                            <th>{{ __t('Session') }}</th>
                            <th>{{ __t('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestInscriptions as $inscription)
                            <tr>
                                <td>{{ $inscription->user?->name ?? '-' }}</td>
                                <td>{{ $inscription->session?->title_fr ?? '-' }}</td>
                                <td><span
                                        class="badge badge-{{ $inscription->status->color() }}">{{ $inscription->status->label() }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .dashboard-container {
            padding: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
        }

        .stat-icon {
            font-size: 32px;
            color: var(--accent);
            margin-bottom: 12px;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--text);
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 10px;
        }

        .stat-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 12px;
        }

        .dashboard-section {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .section-header h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text);
        }

        .section-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 12px;
        }

        .dashboard-table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard-table th,
        .dashboard-table td {
            padding: 10px 0;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        .dashboard-table th {
            color: var(--muted);
            font-weight: 500;
            font-size: 12px;
        }

        .dashboard-table td {
            color: var(--text);
            font-size: 13px;
        }
    </style>

@endsection