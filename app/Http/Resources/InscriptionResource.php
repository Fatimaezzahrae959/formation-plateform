<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'reference' => $this->reference,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'note' => $this->note,
            'registration_date' => $this->registration_date?->toISOString(),
            'confirmed_at' => $this->confirmed_at?->toISOString(),
            'cancelled_at' => $this->cancelled_at?->toISOString(),
            'session' => new SessionResource($this->whenLoaded('session')),
            'formation' => new FormationResource($this->whenLoaded('session.formation')),
        ];
    }
}