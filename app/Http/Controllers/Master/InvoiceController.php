<?php

namespace App\Http\Controllers\Master;

use App\DataTables\ClientsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request, ClientsDataTable $clientsDataTable)
    {
        if(auth()->user()->can('view client invoices')) {
            $title = array(
                'menu' => 'invoices',
                'page' => 'Invoices'
            );

            if($request->ajax()) {
                return $clientsDataTable->getClientInvoices();
            }

            return view('master.invoices.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }


    public function show(Invoice $invoice)
    {
        if(auth()->user()->can('view client invoices')) {
            $title = array(
                'menu' => 'invoices',
                'page' => 'INV ' . $invoice->invoice_no
            );

            return view('master.invoices.show', compact(
                'title',
                'invoice'
            ));
        } else {
            return abort('403');
        }
    }

}
