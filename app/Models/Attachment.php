<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Attachment extends Model
{
    use HasFactory, BelongsToTenant;

    public $fillable = [
        'name',
        'url',
        'extension',
        'attachable_id',
        'attachable_type'
    ];

    public function attachable()
    {
        return $this->morphTo();
    }
}
