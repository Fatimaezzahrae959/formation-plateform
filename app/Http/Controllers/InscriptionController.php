<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\User;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with('user', 'session')->latest()->paginate(25);
        return view('inscriptions.index', compact('inscriptions'));
    }

    public function create()
    {
        $users = User::where('role', 'participant')->get();
        $sessions = Session::with('formation')->get();
        return view('inscriptions.create', compact('users', 'sessions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|exists:sessions,id',
            'status' => 'required|in:pending,confirmed,cancelled',
            'note' => 'nullable|string',
        ]);

        Inscription::create([
            'user_id' => $request->user_id,
            'session_id' => $request->session_id,
            'reference' => 'INS-' . strtoupper(Str::random(8)),
            'status' => $request->status,
            'note' => $request->note,
            'confirmed_at' => $request->status === 'confirmed' ? now() : null,
            'cancelled_at' => $request->status === 'cancelled' ? now() : null,
        ]);

        return redirect()->route('inscriptions.index')->with('success', 'Inscription ajoutée avec succès !');
    }

    public function edit(Inscription $inscription)
    {
        $users = User::where('role', 'participant')->get();
        $sessions = Session::with('formation')->get();
        return view('inscriptions.edit', compact('inscription', 'users', 'sessions'));
    }

    public function update(Request $request, Inscription $inscription)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|exists:sessions,id',
            'status' => 'required|in:pending,confirmed,cancelled',
            'note' => 'nullable|string',
        ]);

        $inscription->update([
            'user_id' => $request->user_id,
            'session_id' => $request->session_id,
            'status' => $request->status,
            'note' => $request->note,
            'confirmed_at' => $request->status === 'confirmed' ? now() : null,
            'cancelled_at' => $request->status === 'cancelled' ? now() : null,
        ]);

        return redirect()->route('inscriptions.index')->with('success', 'Inscription modifiée avec succès !');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return redirect()->route('inscriptions.index')->with('success', 'Inscription supprimée !');
    }
}