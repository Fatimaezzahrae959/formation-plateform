<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\FormationStatus;
use App\Enums\SessionStatus;
use App\Enums\InscriptionStatus;
use App\Enums\BlogStatus;

class AjaxController extends Controller
{
    // ── DELETE ──────────────────────────────────────
    public function delete($table, $id)
    {
        try {
            DB::table($table)->where('id', $id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // ── TOGGLE STATUS ────────────────────────────────
    public function toggleStatus($table, $id)
    {
        $record = DB::table($table)->where('id', $id)->first();
        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Not found']);
        }

        $currentStatus = $record->status;
        $newStatus = $this->getNextStatus($table, $currentStatus);
        $newLabel = $this->getStatusLabel($table, $newStatus);
        $newColor = $this->getStatusColor($table, $newStatus);

        DB::table($table)->where('id', $id)->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'new_status' => $newStatus,
            'new_status_label' => $newLabel,
            'new_status_color' => $newColor,
        ]);
    }

    // ── NEXT STATUS حسب كل table ─────────────────────
    private function getNextStatus($table, $current): string
    {
        $cycles = [
            'formations' => ['brouillon' => 'publie', 'publie' => 'archive', 'archive' => 'brouillon'],
            'blogs' => ['brouillon' => 'publie', 'publie' => 'archive', 'archive' => 'brouillon'],
            'sessions' => ['active' => 'inactive', 'inactive' => 'active'],
            'inscriptions' => ['pending' => 'confirmed', 'confirmed' => 'cancelled', 'cancelled' => 'pending'],
            'users' => ['1' => '0', '0' => '1', 1 => '0', 0 => '1'],
        ];

        return $cycles[$table][$current] ?? $current;
    }

    // ── LABEL حسب STATUS ─────────────────────────────
    private function getStatusLabel($table, $status): string
    {
        $labels = [
            'formations' => [
                'brouillon' => 'Brouillon',
                'publie' => 'Publié',
                'archive' => 'Archivé',
            ],
            'blogs' => [
                'brouillon' => 'Brouillon',
                'publie' => 'Publié',
                'archive' => 'Archivé',
            ],
            'sessions' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
            'inscriptions' => [
                'pending' => 'En attente',
                'confirmed' => 'Confirmé',
                'cancelled' => 'Annulé',
            ],
            'users' => [
                '1' => 'Actif',
                '0' => 'Inactif',
            ],
        ];

        return $labels[$table][$status] ?? ucfirst($status);
    }

    // ── COLOR حسب STATUS ─────────────────────────────
    private function getStatusColor($table, $status): string
    {
        $colors = [
            'brouillon' => 'warning',
            'publie' => 'success',
            'archive' => 'danger',
            'active' => 'success',
            'inactive' => 'danger',
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            '1' => 'success',
            '0' => 'danger',
        ];

        return $colors[$status] ?? 'warning';
    }

    public function search($table, Request $request)
    {

        $q = $request->get('q', '');

        $allowedTables = ['formations', 'sessions', 'inscriptions', 'blogs', 'categories', 'users'];
        if (!in_array($table, $allowedTables)) {
            return response()->json([]);
        }

        switch ($table) {

            case 'formations':
                $results = \App\Models\Formation::with('category')
                    ->where(function ($query) use ($q) {
                        $query->where('title_fr', 'like', "%$q%")
                            ->orWhere('title_en', 'like', "%$q%")
                            ->orWhere('status', 'like', "%$q%")
                            ->orWhereHas('category', fn($c) => $c->where('name_fr', 'like', "%$q%"));
                    })
                    ->limit(20)->get()
                    ->map(fn($f) => [
                        'id' => $f->id,
                        'title_fr' => $f->title_fr,
                        'title_en' => $f->title_en,
                        'category' => $f->category?->name_fr ?? '-',
                        'duration' => $f->duration ?? '-',
                        'price' => $f->price . ' MAD',
                        'level' => $f->level ?? '-',
                        'status_label' => $f->status->label(),
                        'status_color' => $f->status->color(),
                        'edit_url' => route('formations.edit', $f->id),
                    ]);
                break;

            case 'sessions':
                $results = \App\Models\Session::with('formation', 'formateur')
                    ->where(function ($query) use ($q) {
                        $query->where('title_fr', 'like', "%$q%")
                            ->orWhere('title_en', 'like', "%$q%")
                            ->orWhere('mode', 'like', "%$q%")
                            ->orWhereHas('formateur', fn($u) => $u->where('name', 'like', "%$q%"));
                    })
                    ->limit(20)->get()
                    ->map(fn($s) => [
                        'id' => $s->id,
                        'title_fr' => $s->title_fr,
                        'title_en' => $s->title_en,
                        'formation' => $s->formation?->title_fr ?? '-',
                        'formateur' => $s->formateur?->name ?? '-',
                        'start_date' => $s->start_date,
                        'end_date' => $s->end_date,
                        'capacity' => $s->capacity,
                        'mode' => $s->mode,
                        'city' => $s->city ?? '-',
                        'status_label' => $s->status->label(),
                        'status_color' => $s->status->color(),
                        'edit_url' => route('sessions.edit', $s->id),
                    ]);
                break;

            case 'inscriptions':
                $results = \App\Models\Inscription::with('user', 'session')
                    ->where(function ($query) use ($q) {
                        $query->where('reference', 'like', "%$q%")
                            ->orWhere('status', 'like', "%$q%")
                            ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$q%"));
                    })
                    ->limit(20)->get()
                    ->map(fn($i) => [
                        'id' => $i->id,
                        'reference' => $i->reference,
                        'participant' => $i->user?->name ?? '-',
                        'session' => $i->session?->title_fr ?? '-',
                        'status_label' => $i->status->label(),
                        'status_color' => $i->status->color(),
                        'note' => $i->note ?? '-',
                        'confirmed_at' => $i->confirmed_at ?? '-',
                        'cancelled_at' => $i->cancelled_at ?? '-',
                        'edit_url' => route('inscriptions.edit', $i->id),
                    ]);
                break;
            case 'blogs':
                $results = \App\Models\Blog::with('category', 'auteur')
                    ->where(function ($query) use ($q) {
                        $query->where('title_fr', 'like', "%$q%")
                            ->orWhere('title_en', 'like', "%$q%")
                            ->orWhere('status', 'like', "%$q%")
                            ->orWhereHas('auteur', fn($u) => $u->where('name', 'like', "%$q%"))
                            ->orWhereHas('category', fn($c) => $c->where('name_fr', 'like', "%$q%"));
                    })
                    ->limit(20)->get()
                    ->map(fn($b) => [
                        'id' => $b->id,
                        'title_fr' => $b->title_fr,
                        'title_en' => $b->title_en,
                        'category' => $b->category?->name_fr ?? '-',
                        'auteur' => $b->auteur?->name ?? '-',
                        'status_label' => $b->status->label(),
                        'status_color' => $b->status->color(),
                        'published_at' => $b->published_at ?? '-',
                        'edit_url' => route('blogs.edit', $b->id),
                    ]);
                break;

            case 'users':
                $results = \App\Models\User::where(function ($query) use ($q) {
                    $query->where('name', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%")
                        ->orWhere('role', 'like', "%$q%")
                        ->orWhere('phone', 'like', "%$q%");
                })
                    ->limit(20)->get()
                    ->map(fn($u) => [
                        'id' => $u->id,
                        'name' => $u->name,
                        'email' => $u->email,
                        'phone' => $u->phone ?? '-',
                        'role' => $u->role,
                        'language' => $u->language,
                        'is_active' => $u->is_active ? 'Actif' : 'Inactif',
                        'status_color' => $u->is_active ? 'success' : 'danger',
                        'edit_url' => route('users.edit', $u->id),
                    ]);
                break;

            case 'categories':
                $results = \App\Models\Category::where(function ($query) use ($q) {
                    $query->where('name_fr', 'like', "%$q%")
                        ->orWhere('name_en', 'like', "%$q%")
                        ->orWhere('slug_fr', 'like', "%$q%");
                })
                    ->limit(20)->get()
                    ->map(fn($c) => [
                        'id' => $c->id,
                        'name_fr' => $c->name_fr,
                        'name_en' => $c->name_en,
                        'slug_fr' => $c->slug_fr,
                        'slug_en' => $c->slug_en,
                        'edit_url' => route('categories.edit', $c->id),
                    ]);
                break;

            default:
                $results = collect([]);
        }

        return response()->json($results);

    }

    public function getFormationSessions($id)
    {
        $sessions = \App\Models\Session::where('formation_id', $id)
            ->where('status', 'active')
            ->get(['id', 'title_fr', 'start_date', 'end_date', 'capacity', 'mode', 'city']);

        return response()->json($sessions);
    }
}