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
            background: linear-gradient(135deg, #6c63ff, #00d4ff);
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

        .message-box {
            background: #f8fafc;
            border-left: 3px solid #6c63ff;
            padding: 16px 20px;
            border-radius: 0 8px 8px 0;
            margin: 16px 0;
            color: #475569;
            font-size: 14px;
            line-height: 1.7;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #ede9fe;
            color: #6c63ff;
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
            <h1>✉️ Nouveau message</h1>
            <p>FormationPro — Formulaire de contact</p>
        </div>
        <div class="body">
            <div class="badge">Message reçu</div>
            <div class="greeting">Nouveau message de contact</div>
            <p class="text">Un visiteur vient d'envoyer un message via le formulaire de contact.</p>
            <div class="info-box">
                <div class="info-row">
                    <span class="info-label">Nom</span>
                    <span class="info-val">{{ $contact->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-val">{{ $contact->email }}</span>
                </div>
                @if($contact->phone)
                    <div class="info-row">
                        <span class="info-label">Téléphone</span>
                        <span class="info-val">{{ $contact->phone }}</span>
                    </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Sujet</span>
                    <span class="info-val">{{ $contact->subject }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Reçu le</span>
                    <span class="info-val">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            <p class="text"><strong>Message :</strong></p>
            <div class="message-box">{{ $contact->message }}</div>
        </div>
        <div class="footer">© {{ date('Y') }} FormationPro — Tous droits réservés</div>
    </div>
</body>

</html>