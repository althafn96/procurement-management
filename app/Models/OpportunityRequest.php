<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OpportunityRequest extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    public $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withTrashed();
    }

    public function customer()
    {
        return $this->belongsTo(ClientCustomer::class, 'client_customer_id', 'id')->withTrashed();
    }
}
