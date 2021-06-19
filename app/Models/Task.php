<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    public $guarded = [];

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function assignedStaff()
    {
        return $this->belongsToMany(ClientAdmin::class, 'assigned_staff_task', 'task_id', 'assigned_staff_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function taskable()
    {
        return $this->morphTo();
    }

    public function assignees()
    {
        return $this->morphMany(Assignee::class, 'assignable')->latest();
    }
}
