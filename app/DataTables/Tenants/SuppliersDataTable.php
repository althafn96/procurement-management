<?php
namespace App\DataTables\Tenants;

use App\Models\Supplier;
use DataTables;

class SuppliersDataTable {

    public function getAll()
    {
        $suppliers = Supplier::latest()->get();

        return DataTables::of($suppliers)
                ->addColumn('name', function($supplier) {

                    return '
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40 symbol-sm flex-shrink-0">
                            <img class="" src="'.$supplier->image().'" alt="photo">
                        </div>
                        <div class="ml-4">
                            <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$supplier->full_name.'</div>
                            <a href="#" onclick="return false;" class="text-muted font-weight-bold text-hover-primary">'.$supplier->email.'</a>
                        </div>
                    </div>
                    ';
                })
                ->addColumn('mobile', function($supplier) {
                    return $supplier->mobile;
                })
                ->addColumn('address', function($supplier) {
                    return $supplier->address_flat_no . ' ' . $supplier->address_street . ' ' . $supplier->address_city . '<br/> ' . $supplier->address_state . '<br/> ' . $supplier->address_country . '<br/> ' . $supplier->address_zip;
                })
                ->addColumn('action', function($supplier) {

                })
                ->rawColumns(['name','address'])
                ->make('true');
    }

}
