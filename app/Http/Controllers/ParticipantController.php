<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class ParticipantController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $inscriptions = Inscription::with('session.formation')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total' => $inscriptions->count(),
            'pending' => $inscriptions->where('status', 'pending')->count(),
            'confirmed' => $inscriptions->where('status', 'confirmed')->count(),
            'cancelled' => $inscriptions->where('status', 'cancelled')->count(),
        ];

        return view('participant.dashboard', compact('user', 'inscriptions', 'stats'));
    }
}