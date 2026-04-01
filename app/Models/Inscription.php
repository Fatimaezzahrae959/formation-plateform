<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\InscriptionStatus;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    protected $casts = [
        'status' => InscriptionStatus::class,
    ];
}