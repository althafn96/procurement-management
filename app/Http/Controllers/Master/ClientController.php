<?php

namespace App\Http\Controllers\Master;

use App\DataTables\ClientsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Clients\ClientStoreRequest;
use App\Http\Requests\Master\Clients\ClientUpdateRequest;
use App\Models\Plan;
use App\Models\Tenant;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClientController extends Controller
{
    public function index(Request $request, ClientsDataTable $clientsDataTable)
    {
        if(auth()->user()->can('view all clients')) {
            $title = array(
                'menu' => 'clients',
                'page' => 'Clients'
            );

            if($request->ajax()) {
                return $clientsDataTable->getAll();
            }

            return view('master.clients.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if(auth()->user()->can('create client')) {
            $title = array(
                'menu' => 'clients',
                'page' => 'Create Client'
            );

            $plans = Plan::get();

            return view('master.clients.create', compact(
                'title',
                'plans'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(ClientStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $tenant = Tenant::create($request->except(['admin_email', 'admin_password', '_method']));

            DB::commit();

            $url = route('clients.index');

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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if(auth()->user()->can('edit client')) {
            $client = Tenant::findOrFail($id);

            $title = array(
                'menu' => 'clients',
                'page' => 'Edit Client'
            );

            $plans = Plan::get();

            return view('master.clients.edit', compact(
                'title',
                'client',
                'plans'
            ));
        } else {
            return abort('403');
        }

    }

    public function update(ClientUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $client = Tenant::findOrFail($id);

            $client->update($request->except(['admin_email', 'admin_password', '_method']));

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
        if(auth()->user()->can('remove client')) {
            $client = Tenant::findOrFail($id);

            try {
                foreach($client->admins as $admin) {
                    $admin->user()->delete();
                    $admin->delete();
                }
                $client->delete();

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
}
