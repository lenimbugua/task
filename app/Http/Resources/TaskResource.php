<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'due_date' => $this->due_date,
            'deleted_at' => $this->deleted_at,

            'relationships' => [
                "status" => [
                    'id' => $this->status->id,
                    'name' => $this->status->name,
                    'created_at' => $this->status->created_at,
                    'updated_at' => $this->status->updated_at,
                    'deleted_at' => $this->status->deleted_at,
                ]
            ]
        ];
    }
}
