<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Status extends Model
{
    use HasFactory;

    /**
     * Get the tasks for the status.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the usertasks for the status.
     */
    public function usertasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }
}
