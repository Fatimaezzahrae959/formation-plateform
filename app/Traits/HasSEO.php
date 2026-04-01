<?php

namespace App\Traits;

trait HasSEO
{
    public function getSeoTitle(): string
    {
        $locale = app()->getLocale();
        $field = 'seo_title_' . $locale;
        $title = 'title_' . $locale;

        return $this->$field ?? $this->$title ?? '';
    }

    public function getMetaDesc(): string
    {
        $locale = app()->getLocale();
        $field = 'meta_desc_' . $locale;

        return $this->$field ?? '';
    }

    public function getSlug(): string
    {
        $locale = app()->getLocale();
        $field = 'slug_' . $locale;

        return $this->$field ?? '';
    }

    public function getTitle(): string
    {
        $locale = app()->getLocale();
        $field = 'title_' . $locale;

        return $this->$field ?? '';
    }
}