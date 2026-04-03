<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FormationStatus;  // ← Assurez-vous que cette ligne existe en haut


class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title_fr',
        'title_en',
        'slug_fr',
        'slug_en',
        'short_desc_fr',
        'short_desc_en',
        'desc_fr',
        'desc_en',
        'full_desc_fr',
        'full_desc_en',
        'image',
        'price',
        'duration',
        'level',
        'status',
        'published_at',
        'seo_title_fr',
        'seo_title_en',
        'meta_desc_fr',
        'meta_desc_en',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'price' => 'float',
        'status' => FormationStatus::class,
    ];

    // Relation avec Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relation avec Session (UNE FORMATION A PLUSIEURS SESSIONS)
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    // Relation avec Inscription (via sessions)
    public function inscriptions()
    {
        return $this->hasManyThrough(Inscription::class, Session::class);
    }
}