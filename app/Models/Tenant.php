<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use HasFactory, SoftDeletes;

    public static function booted()
    {
        static::created(function ($tenant) {
            $invoice = $tenant->invoices()->create();
            $invoice->items()->create(['plan_id' => $tenant->plan_id, 'price' => $tenant->plan->price]);
            $invoice->invoice_no = (String)$invoice->invoice_no . '-' . (String)$invoice->id;
            $invoice->save();
        });


        static::updated(function ($tenant) {
            $invoice = $tenant->invoices()->create();
            $invoice->items()->create(['plan_id' => $tenant->plan_id, 'price' => $tenant->plan->price]);
            $invoice->invoice_no = (String)$invoice->invoice_no . '-' . (String)$invoice->id;
            $invoice->save();
        });
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function admins()
    {
        return $this->hasMany(ClientAdmin::class, 'tenant_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class)->latest();
    }

    public function suppliers()
    {
        return $this->hasMany(Supplier::class);
    }

    public function customerOrganizations()
    {
        return $this->hasMany(CustomerOrganization::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function opportunityRequests()
    {
        return $this->hasMany(OpportunityRequest::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function pipelines()
    {
        return $this->hasMany(Pipeline::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public static function getCustomColumns(): array
    {
        return [
            'id',
            'company',
            'vat_number',
            'phone',
            'email',
            'website',
            'plan_id',
            'address_flat_no',
            'address_street',
            'address_city',
            'address_state',
            'address_country',
            'address_zip',
            'status'
        ];
    }
}
