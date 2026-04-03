<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->get('locale', 'fr');

        return [
            'id' => $this->id,
            'title' => $this->{"title_{$locale}"},
            'slug' => $this->{"slug_{$locale}"},
            'short_description' => $this->{"short_description_{$locale}"},
            'description' => $this->{"description_{$locale}"},
            'price' => $this->price,
            'duration' => $this->duration,
            'level' => $this->level,
            'status' => $this->status,
            'image_url' => $this->image ? asset('storage/' . $this->image) : null,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'sessions' => SessionResource::collection($this->whenLoaded('sessions')),
            'seo' => [
                'title' => $this->{"seo_title_{$locale}"},
                'description' => $this->{"meta_description_{$locale}"},
            ],
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}