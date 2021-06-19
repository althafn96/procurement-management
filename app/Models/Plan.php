<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use SoftDeletes;

    public $guarded = [];

    public function clients()
    {
        return $this->hasMany(Tenant::class, 'plan_id');
    }
}
