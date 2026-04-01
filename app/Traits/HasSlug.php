<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->slug_fr = static::generateUniqueSlug($model->title_fr, 'slug_fr');
            $model->slug_en = static::generateUniqueSlug($model->title_en, 'slug_en');
        });

        static::updating(function ($model) {
            if ($model->isDirty('title_fr')) {
                $model->slug_fr = static::generateUniqueSlug($model->title_fr, 'slug_fr', $model->id);
            }
            if ($model->isDirty('title_en')) {
                $model->slug_en = static::generateUniqueSlug($model->title_en, 'slug_en', $model->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, string $column, $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $count = 1;

        while (true) {
            $query = static::where($column, $slug);
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            if (!$query->exists())
                break;
            $slug = $original . '-' . $count++;
        }

        return $slug;
    }


}