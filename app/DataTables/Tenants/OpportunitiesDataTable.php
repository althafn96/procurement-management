<?php
namespace App\DataTables\Tenants;

use App\Models\OpportunityRequest;
use DataTables;

class OpportunitiesDataTable
{
    public function getRequests()
    {
        $requests = OpportunityRequest::latest()->get();

        return DataTables::of($requests)
                ->addColumn('category', function ($request) {
                    return $request->category->code ?? '';
                })
                ->addColumn('supplier', function ($request) {
                    return $request->supplier->full_name ?? '';
                })
                ->addColumn('customer', function ($request) {
                    return $request->customer->full_name ?? '';
                })
                ->addColumn('action', function ($request) {
                })
                ->make('true');
    }
}
