<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\SessionStatus;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_fr',      // ← manquant
        'title_en',      // ← manquant
        'formation_id',
        'formateur_id',
        'start_date',
        'end_date',
        'capacity',
        'mode',
        'city',
        'meeting_link',
        'status',
    ];
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id'); // ✔️
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    protected $casts = [
        'status' => SessionStatus::class,
    ];
}