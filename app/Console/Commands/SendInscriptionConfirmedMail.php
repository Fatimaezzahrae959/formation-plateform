<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\InscriptionConfirmedMail;
use App\Models\Inscription;
use App\Models\User;
use App\Models\Session;
use App\Models\Formation;

class SendInscriptionConfirmedMail extends Command
{
    protected $signature = 'mail:inscription:confirmed {email}';
    protected $description = 'Envoyer email d\'inscription confirmée à un utilisateur';

    public function handle()
    {
        $email = $this->argument('email');

        // ── Création temporaire User pour test ──
        $user = new User([
            'name' => 'Test User',
            'email' => $email,
        ]);

        // ── Création Formation fictive ──
        $formation = new Formation([
            'title_fr' => 'Formation Test',
        ]);

        // ── Création Session fictive ──
        $session = new Session([
            'title_fr' => 'Session Test',
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
            'mode' => 'En ligne',
            'city' => 'Casablanca',
            'meeting_link' => null, // si session en ligne tu peux mettre un lien test
        ]);
        $session->formation = $formation;

        // ── Création Inscription fictive ──
        $inscription = new Inscription();
        $inscription->user = $user;
        $inscription->session = $session;
        $inscription->reference = 'TEST-1234';

        // ── Envoi du mail ──
        try {
            Mail::to($email)->send(new InscriptionConfirmedMail($inscription));
            $this->info("✅ Email d'inscription confirmée envoyé à : {$email}");
        } catch (\Exception $e) {
            $this->error("❌ Erreur lors de l'envoi du mail : " . $e->getMessage());
        }
    }
}