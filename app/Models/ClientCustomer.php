<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ClientCustomer extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    public $fillable = [
        'title',
        'first_name',
        'last_name',
        'dob',
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
        'customer_organization_id'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customerOrganization()
    {
        return $this->belongsTo(CustomerOrganization::class);
    }

    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }
}
