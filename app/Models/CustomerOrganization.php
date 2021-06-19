<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerOrganization extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
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
        'tenant_id'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function customers()
    {
        return $this->hasMany(ClientCustomer::class, 'customer_organization_id', 'id');
    }
}
