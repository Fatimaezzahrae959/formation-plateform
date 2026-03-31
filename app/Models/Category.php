<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Formation;

class Category extends Model
{
    use HasFactory;
    public function formations()
    {
        return $this->hasMany(Formation::class);
    }
    protected $fillable = ['name_fr', 'name_en', 'slug_fr', 'slug_en'];
}
