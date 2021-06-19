<?php
namespace App\DataTables;

use App\Models\Client;
use App\Models\Contact;
use App\Models\Invoice;
use App\Models\Package;
use App\Models\Tenant;
use App\Models\User;
use DataTables;
use Spatie\Permission\Models\Role;

class ClientsDataTable
{

    public function getAll()
    {
        $clients = Tenant::latest()->get();

        return DataTables::of($clients)
                ->addColumn('plan', function($client) {
                    return $client->plan->name;
                })
                ->addColumn('action', function($client) {

                })
                ->addColumn('client', function($client) {
                    return config('app.url') .$client->id;
                })
                ->make('true');
    }


    public function getContacts($client_id)
    {
        $contacts = Contact::where('tenant_id', $client_id)->latest()->get();

        return DataTables::of($contacts)
                ->addColumn('contact', function($contact) {

                    return '
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40 symbol-sm flex-shrink-0">
                            <img class="" src="'.$contact->image().'" alt="photo">
                        </div>
                        <div class="ml-4">
                            <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$contact->full_name.'</div>
                            <a href="#" onclick="return false;" class="text-muted font-weight-bold text-hover-primary">'.$contact->email.'</a>
                        </div>
                    </div>
                    ';
                })
                ->addColumn('client', function($contact) {
                    return $contact->client->company;
                })
                ->addColumn('designation', function($contact) {
                    return $contact->position;
                })
                ->addColumn('action', function($contact) {
                })
                ->rawColumns(['contact'])
                ->make('true');
    }




    public function getClientInvoices()
    {
        $invoices = Invoice::whereHas('tenant')->latest()->get();

        return DataTables::of($invoices)
                ->addColumn('client', function($invoice) {
                    return $invoice->tenant->company;
                })
                ->addColumn('invoice_no', function($invoice) {
                    return 'INV ' . $invoice->invoice_no;
                })
                ->addColumn('date', function($invoice) {
                    return $invoice->created_at->format('M d, Y');
                })
                ->addColumn('status', function($invoice) {
                    if($invoice->tenant->invoice->id == $invoice->id) {
                        return '
                            <span class="label label-success label-dot mr-2"></span>
                            <span class="font-weight-bold text-success">Current Plan</span>
                        ';
                    } else {
                        return '
                            <span class="label label-danger label-dot mr-2"></span>
                            <span class="font-weight-bold text-danger">Not Current Plan</span>
                        ';
                    }
                })
                ->addColumn('action', function($invoice) {
                })
                ->rawColumns(['status'])
                ->make('true');
    }

}
