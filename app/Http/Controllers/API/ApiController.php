<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormationResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\InscriptionResource;
use App\Http\Resources\UserResource;
use App\Models\Formation;
use App\Models\Category;
use App\Models\Inscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiController extends Controller
{
    // ==================== API PUBLIQUE ====================

    /**
     * Liste des formations (publique)
     * GET /api/formations
     */
    public function formations(Request $request)
    {
        $formations = Formation::with(['category', 'sessions'])
            ->where('status', 'published')
            ->paginate($request->per_page ?? 15);

        return FormationResource::collection($formations);
    }

    /**
     * Détail d'une formation par slug
     * GET /api/formations/{slug}
     */
    public function formationDetail($slug, Request $request)
    {
        $locale = $request->get('locale', 'fr');

        $formation = Formation::with(['category', 'sessions.formateur'])
            ->where("slug_{$locale}", $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return new FormationResource($formation);
    }

    /**
     * Liste des catégories (publique)
     * GET /api/categories
     */
    public function categories(Request $request)
    {
        $locale = $request->get('locale', 'fr');

        $categories = Category::select('id', "name_{$locale} as name", "slug_{$locale} as slug")
            ->withCount('formations')
            ->get();

        return CategoryResource::collection($categories);
    }

    // ==================== API PROTÉGÉE (SANCTUM) ====================

    /**
     * Connexion - génère un token
     * POST /api/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email ou mot de passe incorrect'
            ], 401);
        }

        // Vérifier si l'utilisateur est actif
        if (!$user->is_active) {
            return response()->json([
                'message' => 'Votre compte est désactivé'
            ], 403);
        }

        // Supprimer les anciens tokens
        $user->tokens()->delete();

        // Créer un nouveau token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => new UserResource($user),
        ]);
    }

    /**
     * Déconnexion - révoque le token
     * POST /api/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Déconnecté avec succès.',
        ]);
    }

    /**
     * Profil utilisateur connecté
     * GET /api/profile
     */
    public function profile(Request $request)
    {
        return new UserResource($request->user()->load('roles'));
    }

    /**
     * Liste des inscriptions du participant connecté
     * GET /api/my-inscriptions
     */
    public function myInscriptions(Request $request)
    {
        $inscriptions = Inscription::with(['session.formation', 'session.formateur'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return InscriptionResource::collection($inscriptions);
    }

    /**
     * Créer une nouvelle inscription
     * POST /api/inscriptions
     */
    public function storeInscription(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:sessions,id',
        ]);

        $user = $request->user();

        // Vérifier si déjà inscrit
        $existing = Inscription::where('user_id', $user->id)
            ->where('session_id', $request->session_id)
            ->first();

        if ($existing) {
            return response()->json([
                'message' => 'Vous êtes déjà inscrit à cette session.',
            ], 422);
        }

        // Vérifier la capacité de la session
        $session = \App\Models\Session::find($request->session_id);
        $currentInscriptions = Inscription::where('session_id', $request->session_id)
            ->where('status', 'confirmed')
            ->count();

        if ($currentInscriptions >= $session->capacity) {
            return response()->json([
                'message' => 'Cette session a atteint sa capacité maximale.',
            ], 422);
        }

        $inscription = Inscription::create([
            'user_id' => $user->id,
            'session_id' => $request->session_id,
            'reference' => 'INV-' . strtoupper(uniqid()),
            'status' => 'pending',
            'registration_date' => now(),
        ]);

        return new InscriptionResource($inscription);
    }

    /**
     * Détail d'une inscription spécifique
     * GET /api/inscriptions/{id}
     */
    public function showInscription($id, Request $request)
    {
        $inscription = Inscription::with(['session.formation', 'session.formateur'])
            ->where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        return new InscriptionResource($inscription);
    }

    /**
     * Annuler une inscription
     * DELETE /api/inscriptions/{id}
     */
    public function cancelInscription($id, Request $request)
    {
        $inscription = Inscription::where('user_id', $request->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($inscription->status === 'cancelled') {
            return response()->json([
                'message' => 'Cette inscription est déjà annulée.',
            ], 422);
        }

        $inscription->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Inscription annulée avec succès.',
        ]);
    }
}