<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Session;
use Carbon\Carbon;

class ArchiveCompletedSessions extends Command
{
    protected $signature = 'sessions:archive';
    protected $description = 'Archiver les sessions terminées';

    public function handle()
    {
        $today = Carbon::today();

        // Sessions dont la date de fin est passée
        $sessions = Session::where('end_date', '<', $today)
            ->where('is_archived', false)
            ->get();

        foreach ($sessions as $session) {
            $session->update(['is_archived' => true]);
        }

        $this->info($sessions->count() . ' session(s) archivée(s).');
    }
}