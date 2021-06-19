<?php
namespace App\DataTables\Master;

use App\Models\Plan;
use DataTables;

class PlansDataTable
{
    public function getAll()
    {
        $plans = Plan::latest()->get();

        return DataTables::of($plans)
                ->addColumn('price', function ($plan) {
                    return config('app.currency') . $plan->price;
                })
                ->addColumn('action', function ($plan) {
                })
                ->make('true');
    }
}
