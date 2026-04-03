<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 40px 20px;
        }

        .wrap {
            max-width: 580px;
            margin: 0 auto;
        }

        .header {
            background: linear-gradient(135deg, #10b981, #06b6d4);
            border-radius: 14px 14px 0 0;
            padding: 36px;
            text-align: center;
        }

        .header h1 {
            color: white;
            font-size: 24px;
            margin: 0;
        }

        .header p {
            color: rgba(255, 255, 255, 0.8);
            margin: 6px 0 0;
            font-size: 14px;
        }

        .body {
            background: white;
            padding: 36px;
            border-radius: 0 0 14px 14px;
            border: 1px solid #e2e8f0;
            border-top: none;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 12px;
        }

        .text {
            color: #64748b;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #94a3b8;
        }

        .info-val {
            color: #1e293b;
            font-weight: 600;
        }

        .badge-success {
            display: inline-block;
            padding: 4px 12px;
            background: #ecfdf5;
            color: #10b981;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 24px;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="header">
            <h1>✅ Inscription confirmée</h1>
            <p>FormationPro</p>
        </div>
        <div class="body">
            <div class="badge-success">Confirmation</div>
            <div class="greeting">Bonjour {{ $inscription->user->name }},</div>
            <p class="text">
                Votre inscription a été <strong>confirmée avec succès</strong>.
                Voici le récapitulatif de votre session :
            </p>
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Référence</span>
                    <span class="info-val">{{ $inscription->reference }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Formation</span>
                    <span class="info-val">{{ $inscription->session->formation->title_fr ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Session</span>
                    <span class="info-val">{{ $inscription->session->title_fr ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date début</span>
                    <span class="info-val">{{ $inscription->session->start_date ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date fin</span>
                    <span class="info-val">{{ $inscription->session->end_date ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Mode</span>
                    <span class="info-val">{{ ucfirst($inscription->session->mode ?? '-') }}</span>
                </div>
                @if($inscription->session->city)
                    <div class="info-row">
                        <span class="info-label">Ville</span>
                        <span class="info-val">{{ $inscription->session->city }}</span>
                    </div>
                @endif
                @if($inscription->session->meeting_link)
                    <div class="info-row">
                        <span class="info-label">Lien réunion</span>
                        <span class="info-val"><a href="{{ $inscription->session->meeting_link }}"
                                style="color:#3b82f6;">Rejoindre</a></span>
                    </div>
                @endif
            </div>
            <p class="text" style="font-size:13px; color:#94a3b8;">
                Pour toute question, contactez-nous à {{ config('mail.from.address') }}.
            </p>
        </div>
        <div class="footer">© {{ date('Y') }} FormationPro — Tous droits réservés</div>
    </div>
</body>

</html>