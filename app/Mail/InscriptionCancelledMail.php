<?php

namespace App\Mail;

use App\Models\Inscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscriptionCancelledMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Inscription $inscription)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Annulation de votre inscription — FormationPro',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.inscription-cancelled',
        );
    }
}