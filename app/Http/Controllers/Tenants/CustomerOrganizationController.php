<?php

namespace App\Http\Controllers\Tenants;

use Exception;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\DataTables\Tenants\CustomersDataTable;
use App\Http\Requests\Tenants\CustomerOrganizations\CustomerOrganizationStoreRequest;
use App\Http\Requests\Tenants\CustomerOrganizations\CustomerOrganizationUpdateRequest;
use App\Models\CustomerOrganization;

class CustomerOrganizationController extends Controller
{
    public function index(Request $request, CustomersDataTable $customersDataTable)
    {
        if (auth()->user()->can('view all customer organizations')) {
            $title = array(
                'menu' => 'customer-organizations',
                'page' => 'Customer Organizations'
            );

            if ($request->ajax()) {
                return $customersDataTable->getAllOrganizations();
            }

            return view('tenants.organizations.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create customer organization')) {
            $title = array(
                'menu' => 'customer-organizations',
                'page' => 'Create Customer Organization'
            );

            return view('tenants.organizations.create', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(CustomerOrganizationStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            tenant()->customerOrganizations()->create($request->all());

            DB::commit();

            $url = route('customer-organizations.index', tenant()->id);

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
        return abort('404');
    }

    public function edit($id)
    {
        if (auth()->user()->can('edit customer organization')) {
            $organization = CustomerOrganization::findOrFail($id);

            $title = array(
                'menu' => 'customer-organizations',
                'page' => 'Edit Customer Organization'
            );

            return view('tenants.organizations.edit', compact(
                'title',
                'organization'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(CustomerOrganizationUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $organization = CustomerOrganization::findOrFail($id);

            $organization->update($request->all());

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
        if (auth()->user()->can('remove customer organization')) {
            DB::beginTransaction();

            try {
                $organization = CustomerOrganization::findOrFail($id);

                if ($organization->customers->count() > 0) {
                    return response('', 409);
                }

                $organization->delete();

                DB::commit();

                return response('', 200);
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
        } else {
            return abort('403');
        }
    }
}
