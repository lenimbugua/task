<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserTask extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the user-task.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the task that owns the user-task.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Get the status that owns the user-task.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
