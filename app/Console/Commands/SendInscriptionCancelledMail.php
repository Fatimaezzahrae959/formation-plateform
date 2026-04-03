<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\InscriptionCancelledMail;
use App\Models\Inscription;
use App\Models\User;
use App\Models\Session;
use App\Models\Formation;

class SendInscriptionCancelledMail extends Command
{
    protected $signature = 'mail:inscription:cancelled {email}';
    protected $description = 'Envoyer email d\'inscription annulée à un utilisateur';

    public function handle()
    {
        $email = $this->argument('email');

        // ── Création temporaire pour test ──
        $user = new User(['name' => 'Test User', 'email' => $email]);

        $formation = new Formation(['title_fr' => 'Formation Test']);

        $session = new Session([
            'title_fr' => 'Session Annulée',
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(2)->format('Y-m-d'),
            'mode' => 'En ligne',
            'city' => 'Casablanca',
            'meeting_link' => null,
        ]);

        $session->formation = $formation;

        $inscription = new Inscription();
        $inscription->user = $user;
        $inscription->session = $session;
        $inscription->reference = 'CANCEL-1234';

        // ── Envoi du mail ──
        Mail::to($email)->send(new InscriptionCancelledMail($inscription));

        $this->info("✅ InscriptionCancelledMail envoyé à : {$email}");
    }
}