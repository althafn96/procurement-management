<?php

namespace App\Http\Controllers\Master;

use App\DataTables\ClientsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Contacts\ContactStoreRequest;
use App\Http\Requests\Master\Contacts\ContactUpdateRequest;
use App\Models\ClientAdmin;
use App\Models\ClientCustomer;
use App\Models\Contact;
use App\Models\Tenant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ContactController extends Controller
{
    public function index(Request $request, ClientsDataTable $clientsDataTable, Tenant $tenant)
    {
        if (auth()->user()->can('view all contacts')) {
            $title = array(
                'menu' => 'clients',
                'page' => $tenant->company . ' | ' . 'Contacts'
            );

            if ($request->ajax()) {
                return $clientsDataTable->getContacts($tenant->id);
            }

            $client = $tenant;
            $contacts = Contact::where('tenant_id', $tenant->id)->latest()->get();

            $client_admin = ClientAdmin::whereHas('contact')->where('tenant_id', $tenant->id)->first();
            $client_guest = ClientCustomer::where('tenant_id', $tenant->id)->first();

            return view('master.client-contacts.index', compact(
                'title',
                'client',
                'contacts',
                'client_admin',
                'client_guest'
            ));
        } else {
            return abort('403');
        }
    }

    public function create(Tenant $tenant)
    {
        $title = array(
            'menu' => 'clients',
            'page' => 'Create Contact'
        );
        $client = $tenant;

        return view('master.client-contacts.create', compact(
            'title',
            'client'
        ));
    }

    public function store(ContactStoreRequest $request, Tenant $tenant)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('profile_avatar')) {
                $request['picture'] = $request->file('profile_avatar')->store('avatars');
            }

            $tenant->contacts()->create($request->except(['profile_avatar', 'profile_avatar_remove', '_method']));

            DB::commit();

            $url = route('contacts.index', [$tenant]);

            return response()->json([
                'type' => 'success',
                'url' =>  $url
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        }
    }


    public function edit(Tenant $tenant, $id)
    {
        if (auth()->user()->can('edit contact')) {
            $contact = Contact::findOrFail($id);

            $title = array(
                'menu' => 'clients',
                'page' => 'Edit Contact'
            );
            $client = $tenant;

            return view('master.client-contacts.edit', compact(
                'title',
                'client',
                'contact'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(ContactUpdateRequest $request, Tenant $tenant, Contact $contact)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('profile_avatar')) {
                $request['picture'] = $request->file('profile_avatar')->store('avatars');
            }

            $contact->update($request->except(['profile_avatar', 'profile_avatar_remove', '_method']));

            DB::commit();

            return response()->json([
                'type' => 'success'
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ]);
        }
    }

    public function destroy($id)
    {
        if (auth()->user()->can('remove contact')) {
            $contact = Contact::findOrFail($id);

            try {
                $contact->delete();

                return response('', 200);
            } catch (Throwable $e) {
                return response($e, 500);
            } catch (Exception $e) {
                return response($e, 500);
            }
        } else {
            return response('', 403);
        }
    }

    public function invoice(Tenant $tenant)
    {
        $title = array(
            'menu' => 'clients',
            'page' => 'Client Invoice'
        );
        $client = $tenant;

        return view('master.clients.invoice', compact(
            'title',
            'client'
        ));
    }
}
