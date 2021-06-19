<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Project extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    public $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function opportunityRequest()
    {
        return $this->belongsTo(OpportunityRequest::class)->withTrashed();
    }

    public function assignedStaff()
    {
        return $this->belongsTo(ClientAdmin::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id')->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    public function customer()
    {
        return $this->belongsTo(ClientCustomer::class, 'client_customer_id', 'id')->withTrashed();
    }

    public function pipelines()
    {
        return $this->hasMany(Pipeline::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable')->latest();
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
