<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Master extends User
{
    use HasFactory;

    public $fillable = [
        'first_name',
        'last_name',
        'image'
    ];

    public function user() {
        $this->belongsTo(User::class);
    }
}
