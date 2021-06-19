<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    public $guarded = [];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
