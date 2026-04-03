<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReceivedMail;
use App\Models\Contact;

class SendContactReceivedMail extends Command
{
    protected $signature = 'mail:contact:received {email}';
    protected $description = 'Envoyer email pour contact reçu à un utilisateur';

    public function handle()
    {
        $email = $this->argument('email');

        // ── Contact fictif pour test ──
        $contact = new Contact([
            'name' => 'Test User',        // nom du contact
            'email' => $email,            // email passé en argument
            'message' => 'Ceci est un message de test.'  // message fictif
        ]);

        // ── Envoi du mail ──
        Mail::to($email)->send(new ContactReceivedMail($contact));

        $this->info("✅ ContactReceivedMail envoyé à : {$email}");
    }
}