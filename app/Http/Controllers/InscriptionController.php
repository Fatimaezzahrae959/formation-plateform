<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\User;
use App\Models\Formation;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InscriptionConfirmedMail;
use App\Mail\InscriptionCancelledMail;
use App\Enums\InscriptionStatus;
use Illuminate\Validation\Rules\Enum;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with('user', 'session')->latest()->paginate(25);
        return view('inscriptions.index', compact('inscriptions'));
    }

    public function create()
    {
        // ✅ AJOUTE CES VARIABLES
        $users = User::all();
        $formations = Formation::with('sessions')->get();

        return view('inscriptions.create', compact('users', 'formations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|exists:sessions,id',
            'status' => ['required', new Enum(InscriptionStatus::class)],
            'note' => 'nullable|string',
        ]);

        $inscription = Inscription::create([
            'user_id' => $request->user_id,
            'session_id' => $request->session_id,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        // Envoyer email de confirmation si status = confirmed
        if ($inscription->status->value === 'confirmed') {
            Mail::to($inscription->user->email)->send(new InscriptionConfirmedMail($inscription));
        }

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription créée avec succès !');
    }

    public function edit(Inscription $inscription)
    {
        // ✅ AJOUTE CES VARIABLES
        $users = User::all();
        $sessions = Session::with('formation')->get();

        return view('inscriptions.edit', compact('inscription', 'users', 'sessions'));
    }

    public function update(Request $request, Inscription $inscription)
    {
        $oldStatus = $inscription->status->value;

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'session_id' => 'required|exists:sessions,id',
            'status' => ['required', new Enum(InscriptionStatus::class)],
            'note' => 'nullable|string',
        ]);

        $inscription->update([
            'user_id' => $request->user_id,
            'session_id' => $request->session_id,
            'status' => $request->status,
            'note' => $request->note,
        ]);

        // Gérer les dates de confirmation/annulation
        if ($request->status === 'confirmed' && $oldStatus !== 'confirmed') {
            $inscription->confirmed_at = now();
            $inscription->save();
            Mail::to($inscription->user->email)->send(new InscriptionConfirmedMail($inscription));
        } elseif ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            $inscription->cancelled_at = now();
            $inscription->save();
            Mail::to($inscription->user->email)->send(new InscriptionCancelledMail($inscription));
        } elseif ($oldStatus === 'confirmed' && $request->status !== 'confirmed') {
            $inscription->confirmed_at = null;
            $inscription->save();
        } elseif ($oldStatus === 'cancelled' && $request->status !== 'cancelled') {
            $inscription->cancelled_at = null;
            $inscription->save();
        }

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription mise à jour avec succès !');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('inscriptions.index')
            ->with('success', 'Inscription supprimée avec succès !');
    }
}