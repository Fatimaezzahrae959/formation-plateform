<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact — FormationPro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg: #07090f;
            --card: #111827;
            --border: #1e2736;
            --accent: #3b82f6;
            --success: #10b981;
            --danger: #ef4444;
            --text: #f1f5f9;
            --muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .contact-wrap {
            width: 100%;
            max-width: 580px;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 36px;
        }

        .contact-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        .contact-header p {
            color: var(--muted);
            margin-top: 8px;
            font-size: 15px;
        }

        .contact-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 36px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 7px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 11px 14px;
            border-radius: 9px;
            border: 1px solid var(--border);
            background: #0d1117;
            color: var(--text);
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .field-error {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--accent);
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            background: #2563eb;
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 500;
            display: none;
        }

        .alert.success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert.error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
        }
    </style>
</head>

<body>
    <div class="contact-wrap">
        <div class="contact-header">
            <h1><i class="fas fa-graduation-cap" style="color:var(--accent);"></i> FormationPro</h1>
            <p>Envoyez-nous un message, nous vous répondrons rapidement.</p>
        </div>

        <div class="contact-card">
            <div class="alert success" id="alert-success">
                <i class="fas fa-check-circle"></i> <span id="success-msg"></span>
            </div>
            <div class="alert error" id="alert-error">
                <i class="fas fa-exclamation-circle"></i> Une erreur est survenue.
            </div>

            <form id="contact-form">
                @csrf

                <div class="form-row">
                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" name="name" placeholder="Votre nom">
                        <span class="field-error" id="err-name"></span>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="you@example.com">
                        <span class="field-error" id="err-email"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Téléphone</label>
                        <input type="text" name="phone" placeholder="+212 6xx xxx xxx">
                    </div>
                    <div class="form-group">
                        <label>Sujet</label>
                        <input type="text" name="subject" placeholder="Sujet du message">
                        <span class="field-error" id="err-subject"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Message</label>
                    <textarea name="message" placeholder="Votre message..."></textarea>
                    <span class="field-error" id="err-message"></span>
                </div>

                <button type="submit" class="btn-submit" id="submit-btn">
                    <i class="fas fa-paper-plane"></i> Envoyer le message
                </button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('contact-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = document.getElementById('submit-btn');
            const alertOk = document.getElementById('alert-success');
            const alertErr = document.getElementById('alert-error');
            const formData = new FormData(this);

            // Reset errors
            ['name', 'email', 'subject', 'message'].forEach(f => {
                document.getElementById(`err-${f}`).textContent = '';
            });
            alertOk.style.display = 'none';
            alertErr.style.display = 'none';

            // Loading
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';

            fetch('{{ route("contact.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alertOk.style.display = 'flex';
                        document.getElementById('success-msg').textContent = data.message;
                        this.reset();
                    } else if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            const el = document.getElementById(`err-${field}`);
                            if (el) el.textContent = data.errors[field][0];
                        });
                        alertErr.style.display = 'flex';
                    }
                })
                .catch(() => {
                    alertErr.style.display = 'flex';
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Envoyer le message';
                });
        });
    </script>
</body>

</html>