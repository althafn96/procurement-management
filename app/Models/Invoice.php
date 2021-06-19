<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public $guarded = [];


    public static function booted()
    {
        static::creating(function($invoice) {
            $now = Carbon::now()->setTimezone('Asia/Colombo');
            $year = substr($now->year, -2);
            $month = $now->month;
            $day = $now->month;

            if(strlen($month) == 1) {
                $month = '0' . $month;
            }
            if(strlen($day) == 1) {
                $day = '0' . $day;
            }

            $invoice->invoice_no = $year . $month . $day;
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class)->whereNull('deleted_at');
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
