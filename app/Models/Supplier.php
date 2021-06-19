<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Supplier extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    public $guarded = [];


    public function getFullNameAttribute()
    {
        return ucwords("{$this->first_name} {$this->last_name}");
    }


    public function image()
    {
        if($this->image) {
            return global_asset('storage/'.$this->image);
        } else {
            return url('/assets/media/users/blank.png');
        }
    }
}
