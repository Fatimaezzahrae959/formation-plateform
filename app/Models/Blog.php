<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasSlug;
use App\Traits\HasSEO;


class Blog extends Model
{
    use HasFactory, HasSlug, HasSEO;

    protected $fillable = [
        'category_id',
        'user_id',
        'title_fr',
        'title_en',
        'slug_fr',
        'slug_en',
        'content_fr',
        'content_en',
        'image',
        'status',
        'published_at',
        'seo_title_fr',
        'seo_title_en',
        'meta_desc_fr',
        'meta_desc_en',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function auteur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}