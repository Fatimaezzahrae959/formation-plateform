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
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 14px 14px 0 0;
            padding: 36px;
            text-align: center;
        }

        .header h1 {
            color: white;
            font-size: 24px;
            margin: 0;
            letter-spacing: -0.3px;
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

        .btn {
            display: inline-block;
            padding: 12px 28px;
            background: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .divider {
            border: none;
            border-top: 1px solid #f1f5f9;
            margin: 28px 0;
        }

        .footer {
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            margin-top: 24px;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #eff6ff;
            color: #3b82f6;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="header">
            <h1>🎓 FormationPro</h1>
            <p>Plateforme de formations professionnelles</p>
        </div>
        <div class="body">
            <div class="badge">Bienvenue !</div>
            <div class="greeting">Bonjour {{ $user->name }},</div>
            <p class="text">
                Nous sommes ravis de vous accueillir sur <strong>FormationPro</strong> !
                Votre compte a été créé avec succès. Vous pouvez dès maintenant accéder
                à toutes nos formations et vous inscrire aux sessions de votre choix.
            </p>
            <p class="text">
                <strong>Vos informations :</strong><br>
                Email : {{ $user->email }}<br>
                Rôle : {{ ucfirst($user->role ?? 'participant') }}
            </p>
            <a href="{{ config('http://127.0.0.1:8000/admin/dashboard') }}" class="btn">Accéder à la plateforme</a>
            <hr class="divider">
            <p class="text" style="font-size:13px;">
                Si vous n'avez pas créé ce compte, ignorez cet email.
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} FormationPro — Tous droits réservés
        </div>
    </div>
</body>

</html>