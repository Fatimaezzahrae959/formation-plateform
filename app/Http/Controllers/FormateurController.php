<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class FormateurController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        $sessions = Session::with('formation')
            ->where('formateur_id', $user->id)
            ->latest()
            ->get();

        $stats = [
            'total_sessions' => $sessions->count(),
            'sessions_active' => $sessions->where('status', 'active')->count(),
            'sessions_inactive' => $sessions->where('status', 'inactive')->count(),
            'total_inscrits' => Inscription::whereIn('session_id', $sessions->pluck('id'))->count(),
        ];

        return view('formateur.dashboard', compact('user', 'sessions', 'stats'));
    }
}