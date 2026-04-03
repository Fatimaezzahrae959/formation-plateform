<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->get('locale', 'fr');

        return [
            'id' => $this->id,
            'title' => $this->{"title_{$locale}"},
            'slug' => $this->{"slug_{$locale}"},
            'content' => $this->{"content_{$locale}"},
            'excerpt' => $this->excerpt($locale),
            'status' => $this->status,
            'status_label' => $this->status_label,
            'published_at' => $this->published_at?->toISOString(),
            'author' => new UserResource($this->whenLoaded('author')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'image_url' => $this->featured_image ? asset('storage/' . $this->featured_image) : null,
            'seo' => [
                'title' => $this->{"seo_title_{$locale}"},
                'description' => $this->{"meta_description_{$locale}"},
            ],
        ];
    }

    protected function excerpt($locale, $length = 150)
    {
        $content = $this->{"content_{$locale}"};
        return strlen($content) > $length
            ? substr($content, 0, $length) . '...'
            : $content;
    }
}