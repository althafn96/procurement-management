<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    public $guarded = [];

    public function client()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function image()
    {
        if ($this->picture) {
            return asset('storage/'.$this->picture);
        } else {
            return url('/assets/media/users/blank.png');
        }
    }

    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }

    public function clientAdmin()
    {
        return $this->hasOne(ClientAdmin::class);
    }
}
