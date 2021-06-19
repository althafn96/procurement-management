<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Assignee extends Model
{
    use HasFactory, BelongsToTenant;

    public $fillable = [
        'user_id',
        'assignable_id',
        'assignable_type'
    ];

    public function assignable()
    {
        return $this->morphTo();
    }
}
