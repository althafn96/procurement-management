<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissions, HasRoles;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function details()
    {
        if (auth()->user()->role->type == 'master') {
            return $this->hasOne(Master::class, 'user_id', 'id');
        } elseif (auth()->user()->role->type == 'client') {
            if (auth()->user()->role->name == 'Customer') {
                return $this->hasOne(ClientCustomer::class);
            }
            return $this->hasOne(ClientAdmin::class, 'user_id', 'id');
        }
        return auth()->user()->role->type;
    }

    public function master()
    {
        return $this->hasOne(Master::class, 'user_id', 'id');
    }

    public function clientCustomer()
    {
        return $this->hasOne(ClientCustomer::class, 'user_id', 'id');
    }

    public function clients()
    {
        return $this->hasMany(ClientAdmin::class, 'user_id', 'id');
    }

    public function getImageAttribute()
    {
        $this->image();
    }

    public function image()
    {
        if ($this->details) {
            if ($this->details->picture) {
                return '';
            } else {
                return url('/assets/media/users/blank.png');
            }
        } else {
            if ($this->clientCustomer->picture) {
                return '';
            } else {
                return url('/assets/media/users/blank.png');
            }
        }
    }

    public function getFullNameAttribute()
    {
        return ucwords("{$this->details->first_name} {$this->details->last_name}");
    }
}
