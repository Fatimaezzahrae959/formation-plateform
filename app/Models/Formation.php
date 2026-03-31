<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'publication_date',
        'published_at',
        'seo_title_fr',
        'seo_title_en',
        'meta_desc_fr',
        'meta_desc_en',
    ];

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class);
    }
}