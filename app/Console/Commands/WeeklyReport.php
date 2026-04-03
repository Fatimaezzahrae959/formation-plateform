<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Session;
use App\Models\User;
use App\Models\Inscription;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class WeeklyReport extends Command
{
    protected $signature = 'report:weekly';
    protected $description = 'Envoyer rapport hebdomadaire à l\'administrateur';

    public function handle()
    {
        $lastWeek = Carbon::now()->subWeek();

        $stats = [
            'sessions' => Session::where('created_at', '>=', $lastWeek)->count(),
            'inscriptions' => Inscription::where('created_at', '>=', $lastWeek)->count(),
            'users' => User::where('created_at', '>=', $lastWeek)->count(),
        ];

        // Email de l'admin (à modifier selon votre base de données)
        $adminEmail = 'admin@example.com';

        Mail::raw(
            "=== RAPPORT HEBDOMADAIRE ===\n\n" .
            "Date: " . Carbon::now()->format('d/m/Y') . "\n" .
            "Période: " . $lastWeek->format('d/m/Y') . " - " . Carbon::now()->format('d/m/Y') . "\n\n" .
            "📊 Statistiques:\n" .
            "- Sessions créées: " . $stats['sessions'] . "\n" .
            "- Inscriptions: " . $stats['inscriptions'] . "\n" .
            "- Nouveaux utilisateurs: " . $stats['users'] . "\n\n" .
            "Fin du rapport.",
            function ($mail) use ($adminEmail) {
                $mail->to($adminEmail)->subject('Rapport Hebdomadaire - Formation Platform');
            }
        );

        $this->info('Rapport hebdomadaire envoyé à ' . $adminEmail);
        $this->info("Statistiques: {$stats['sessions']} sessions, {$stats['inscriptions']} inscriptions, {$stats['users']} nouveaux utilisateurs.");
    }
}