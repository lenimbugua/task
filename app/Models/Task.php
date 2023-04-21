<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'due_date',
        'status_id'
    ];

    /**
     * Get the user-tasks for the task.
     */
    public function usertasks(): HasMany
    {
        return $this->hasMany(UserTask::class);
    }

    /**
     * Get the status that owns the task.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
