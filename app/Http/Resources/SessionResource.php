<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = $request->get('locale', 'fr');

        return [
            'id' => $this->id,
            'start_date' => $this->start_date?->toISOString(),
            'end_date' => $this->end_date?->toISOString(),
            'capacity' => $this->capacity,
            'mode' => $this->mode,
            'mode_label' => $this->mode_label,
            'city' => $this->city,
            'meeting_link' => $this->meeting_link,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'formateur' => new UserResource($this->whenLoaded('formateur')),
            'formation' => new FormationResource($this->whenLoaded('formation')),
            'remaining_places' => $this->capacity - ($this->inscriptions_count ?? 0),
        ];
    }
}