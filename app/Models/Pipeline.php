<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pipeline extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    public $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedStaff()
    {
        return $this->belongsToMany(ClientAdmin::class, 'assigned_staff_pipeline', 'pipeline_id', 'assigned_staff_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable')->latest();
    }

    public function assignees()
    {
        return $this->morphMany(Assignee::class, 'assignable')->latest();
    }
}
