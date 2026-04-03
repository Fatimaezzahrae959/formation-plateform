<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\SessionReminderMail;
use Carbon\Carbon;

class SendSessionReminder extends Command
{
    protected $signature = 'reminder:sessions';
    protected $description = 'Envoyer rappels 24h avant le début de chaque session';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        // Inscriptions dont la session commence demain
        $inscriptions = Inscription::with(['user', 'session.formation'])
            ->whereHas('session', function ($q) use ($tomorrow) {
                $q->whereDate('start_date', $tomorrow);
            })
            ->take(1)
            ->get();

        foreach ($inscriptions as $inscription) {
            Mail::to($inscription->user->email)
                ->send(new SessionReminderMail($inscription));

            $this->info("Rappel envoyé à : {$inscription->user->email}");
        }

        $this->info("Total : {$inscriptions->count()} rappel(s) envoyé(s).");
    }
}