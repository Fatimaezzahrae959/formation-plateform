<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Models\User;

class SendWelcomeMail extends Command
{
    protected $signature = 'mail:welcome {email}';
    protected $description = 'Envoyer email de bienvenue à un utilisateur';

    public function handle()
    {
        $email = $this->argument('email');

        // ── Création temporaire User fictif pour test ──
        $user = new User([
            'name' => 'Test User',
            'email' => $email
        ]);

        // ── Envoi du mail ──
        Mail::to($email)->send(new WelcomeMail($user));

        $this->info("✅ WelcomeMail envoyé à : {$email}");
    }
}