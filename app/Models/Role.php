<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends SpatieRole
{
    use SoftDeletes;

    public $guarded = [];

    public function getNameAttribute($name)
    {
        $name_arr = explode('-', $name);
        return end($name_arr);
    }

    public function roleUsers()
    {
        return $this->hasMany(User::class);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
