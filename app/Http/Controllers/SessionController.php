<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Session;
use App\Models\Formation;
use App\Models\User;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = \App\Models\Session::with('formation', 'formateur')->latest()->paginate(10);
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        $formations = Formation::all();
        $formateurs = User::where('role', 'formateur')->get();
        return view('sessions.create', compact('formations', 'formateurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'formation_id' => 'required|exists:formations,id',
            'formateur_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:1',
            'mode' => 'required|in:présentiel,en ligne,hybride',
            'city' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        Session::create([
            'title_fr' => $request->title_fr,
            'title_en' => $request->title_en,
            'formation_id' => $request->formation_id,
            'formateur_id' => $request->formateur_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'capacity' => $request->capacity,
            'mode' => $request->mode,
            'city' => $request->city,
            'meeting_link' => $request->meeting_link,
            'status' => $request->status,
        ]);

        return redirect()->route('sessions.index')->with('success', 'Session ajoutée avec succès !');
    }
    public function edit(Session $session)
    {
        $formations = Formation::all();
        $formateurs = User::where('role', 'formateur')->get();
        return view('sessions.edit', compact('session', 'formations', 'formateurs'));
    }

    public function update(Request $request, Session $session)
    {
        $request->validate([
            'formation_id' => 'required|exists:formations,id',
            'formateur_id' => 'required|exists:users,id',
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:1',
            'mode' => 'required|in:présentiel,en ligne,hybride',
            'city' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url',
            'status' => 'required|in:active,inactive',
        ]);

        $session->update($request->all());

        return redirect()->route('sessions.index')->with('success', 'Session modifiée avec succès !');
    }

    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('sessions.index')->with('success', 'Session supprimée avec succès !');
    }
}