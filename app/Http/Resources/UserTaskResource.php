<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTaskResource extends JsonResource
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
            'due_date' => $this->due_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'remarks' => $this->remarks,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'relationships' => [
                "status" => [
                    'id' => $this->status->id,
                    'name' => $this->status->name,
                    'created_at' => $this->status->created_at,
                    'updated_at' => $this->status->updated_at,
                    'deleted_at' => $this->status->deleted_at,
                ],
                "task" => [
                    'id' => $this->task->id,
                    'name' => $this->task->name,
                    'description' => $this->task->description,
                    'status_id' => $this->task->status_id,
                    'due_date' => $this->task->due_date,
                    'created_at' => $this->task->created_at,
                    'updated_at' => $this->task->updated_at,
                    'deleted_at' => $this->status->deleted_at,
                ]
            ]
        ];
    }
}
