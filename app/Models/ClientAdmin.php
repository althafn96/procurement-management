<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAdmin extends Model
{
    use HasFactory;

    public $fillable = [
        'title',
        'first_name',
        'last_name',
        'dob',
        'position',
        'image',
        'email',
        'phone',
        'fax',
        'mobile',
        'address_flat_no',
        'address_street',
        'address_city',
        'address_state',
        'address_country',
        'address_zip',
        'tenant_id',
        'user_id',
        'contact_id',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }

    public function assignedPipelines()
    {
        return $this->belongsToMany(ClientAdmin::class, 'assigned_staff_pipeline', 'assigned_staff_id', 'pipeline_id');
    }
}
