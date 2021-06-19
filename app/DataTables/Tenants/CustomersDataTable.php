<?php
namespace App\DataTables\Tenants;

use App\Models\ClientCustomer;
use App\Models\CustomerOrganization;
use DataTables;

class CustomersDataTable
{
    public function getAll()
    {
        $customers = ClientCustomer::where('first_name', '!=', 'Guest')->where('last_name', '!=', 'User')->latest()->get();

        return DataTables::of($customers)
                ->addColumn('name', function ($customer) {
                    return '
                    <div class="d-flex align-items-center">
                        <div class="ml-4">
                            <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$customer->full_name.'</div>
                        </div>
                    </div>
                    ';
                })
                ->addColumn('address', function ($customer) {
                    return $customer->address_flat_no . ' ' . $customer->address_street . ' ' . $customer->address_city . '<br/> ' . $customer->address_state . '<br/> ' . $customer->address_country . '<br/> ' . $customer->address_zip;
                })
                ->addColumn('organization', function ($customer) {
                    return $customer->customerOrganization == '' ? '' : $customer->customerOrganization->name;
                })
                ->addColumn('action', function ($customer) {
                })
                ->rawColumns(['name', 'address'])
                ->make('true');
    }

    public function getAllOrganizations()
    {
        $organizations = CustomerOrganization::latest()->get();

        return DataTables::of($organizations)
                ->addColumn('name', function ($organization) {
                    return $organization->name;
                })
                ->addColumn('address', function ($organization) {
                    return $organization->address_flat_no . ' ' . $organization->address_street . ' ' . $organization->address_city . '<br/> ' . $organization->address_state . '<br/> ' . $organization->address_country . '<br/> ' . $organization->address_zip;
                })
                ->addColumn('action', function ($organization) {
                })
                ->rawColumns(['name', 'address'])
                ->make('true');
    }
}
