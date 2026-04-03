<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReceivedMail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact = Contact::create($request->all());

        // ── Email vers admin ──
        Mail::to(config('mail.from.address'))->send(new ContactReceivedMail($contact));

        return response()->json([
            'success' => true,
            'message' => 'Votre message a été envoyé avec succès !',
        ]);
    }

    public function adminIndex()
    {
        $contacts = Contact::latest()->paginate(25);
        return view('contact.admin', compact('contacts'));
    }

    public function updateStatus(Request $request, Contact $contact)
    {
        $contact->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(['success' => true]);
    }
}