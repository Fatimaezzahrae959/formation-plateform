<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InscriptionStatus;
use Illuminate\Support\Str;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'reference',
        'status',
        'note',
        'confirmed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'status' => InscriptionStatus::class,
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    // Générer automatiquement la référence
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inscription) {
            // Générer une référence unique
            $inscription->reference = 'INS-' . strtoupper(Str::random(8));

            // Gérer les dates selon le statut
            if ($inscription->status->value === 'confirmed') {
                $inscription->confirmed_at = now();
            } elseif ($inscription->status->value === 'cancelled') {
                $inscription->cancelled_at = now();
            }
        });

        static::updating(function ($inscription) {
            // Gérer les dates quand le statut change
            if ($inscription->isDirty('status')) {
                if ($inscription->status->value === 'confirmed') {
                    $inscription->confirmed_at = now();
                } elseif ($inscription->status->value === 'cancelled') {
                    $inscription->cancelled_at = now();
                } else {
                    $inscription->confirmed_at = null;
                    $inscription->cancelled_at = null;
                }
            }
        });
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}