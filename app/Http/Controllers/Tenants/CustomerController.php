<?php

namespace App\Http\Controllers\Tenants;

use App\DataTables\Tenants\CustomersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\Customers\CustomerStoreRequest;
use App\Http\Requests\Tenants\Customers\CustomerUpdateRequest;
use App\Models\ClientAdmin;
use App\Models\ClientCustomer;
use App\Models\CustomerOrganization;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{
    public function index(Request $request, CustomersDataTable $customersDataTable)
    {
        if (auth()->user()->can('view all stakeholders')) {
            $title = array(
                'menu' => 'stakeholders',
                'page' => 'Stakeholders'
            );

            if ($request->ajax()) {
                return $customersDataTable->getAll();
            }

            return view('tenants.customers.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create stakeholder')) {
            $title = array(
                'menu' => 'stakeholder',
                'page' => 'Create Stakeholder'
            );

            return view('tenants.customers.create', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(CustomerStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            // if ($request->hasFile('profile_avatar')) {
            //     $request['image'] = $request->file('profile_avatar')->store('avatars');
            // }

            // $user = User::create([
            //     'email' => $request->email,
            //     'password' => bcrypt($request->password),
            //     'role_id' => '3'
            // ]);

            ClientCustomer::create(array_merge($request->all(), ['tenant_id' => tenant()->id, 'user_id' => 0]));

            // if ($request->has('permissions')) {
            //     $user->givePermissionTo($user->role->persmissions);
            // }

            DB::commit();

            $url = route('stakeholders.index', tenant()->id);

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
        if (auth()->user()->can('edit stakeholder')) {
            $customer = ClientCustomer::findOrFail($id);

            $title = array(
                'menu' => 'stakeholder',
                'page' => 'Edit Stakeholder'
            );

            return view('tenants.customers.edit', compact(
                'title',
                'customer'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(CustomerUpdateRequest $request, $id)
    {
        $customer = ClientCustomer::findOrFail($id);
        // $user = $customer->user;

        DB::beginTransaction();

        try {
            // if ($request->hasFile('profile_avatar')) {
            //     $request['image'] = $request->file('profile_avatar')->store('avatars');
            // } else {
            //     $request['image'] = $customer->image;
            // }

            // $user->update([
            //     'email' => $request->email,
            //     'password' => $request->password == '' ? $user->password : bcrypt($request->password)
            // ]);

            $customer->update(array_merge($request->all(), ['tenant_id' => tenant()->id]));

            // $user->syncPermissions($user->role->permissions);

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
        $customer = ClientCustomer::findOrFail($id);

        DB::beginTransaction();

        try {
            // $customer->user()->delete();
            $customer->delete();

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
}
