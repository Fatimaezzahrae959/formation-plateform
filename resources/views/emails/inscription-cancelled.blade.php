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
            background: linear-gradient(135deg, #ef4444, #f97316);
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
            background: #fff5f5;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #fef2f2;
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

        .badge-danger {
            display: inline-block;
            padding: 4px 12px;
            background: #fef2f2;
            color: #ef4444;
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
            <h1>❌ Inscription annulée</h1>
            <p>FormationPro</p>
        </div>
        <div class="body">
            <div class="badge-danger">Annulation</div>
            <div class="greeting">Bonjour {{ $inscription->user->name }},</div>
            <p class="text">
                Nous vous informons que votre inscription a été <strong>annulée</strong>.
                Voici les détails de l'inscription concernée :
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
                    <span class="info-label">Annulé le</span>
                    <span class="info-val">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <p class="text">
                Si vous pensez qu'il s'agit d'une erreur ou souhaitez vous réinscrire,
                n'hésitez pas à nous contacter.
            </p>
            <p class="text" style="font-size:13px; color:#94a3b8;">
                Contact : {{ config('mail.from.address') }}
            </p>
        </div>
        <div class="footer">© {{ date('Y') }} FormationPro — Tous droits réservés</div>
    </div>
</body>

</html>