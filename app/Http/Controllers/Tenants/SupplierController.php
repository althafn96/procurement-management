<?php

namespace App\Http\Controllers\Tenants;

use App\DataTables\Tenants\SuppliersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\Suppliers\SupplierStoreRequest;
use App\Http\Requests\Tenants\Suppliers\SupplierUpdateRequest;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class SupplierController extends Controller
{
    public function index(Request $request, SuppliersDataTable $suppliersDataTable)
    {
        if (auth()->user()->can('view all suppliers')) {
            $title = array(
                'menu' => 'suppliers',
                'page' => 'Suppliers'
            );

            if ($request->ajax()) {
                return $suppliersDataTable->getAll();
            }

            return view('tenants.suppliers.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create supplier')) {
            $title = array(
                'menu' => 'suppliers',
                'page' => 'Create Supplier'
            );

            return view('tenants.suppliers.create', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(SupplierStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('profile_avatar')) {
                $request['image'] = $request->file('profile_avatar')->store(tenant()->id . '/avatars');
            }

            $supplier = tenant()->suppliers()->create($request->except(['profile_avatar_remove', 'profile_avatar', 'add_from']));

            DB::commit();

            if ($request->has('add_from') && $request->add_from == 'oppurtunity_request') {
                return response()->json([
                    'type' => 'success',
                    'supplier' =>  $supplier
                ]);
            } else {
                $url = route('suppliers.index', tenant()->id);

                return response()->json([
                    'type' => 'success',
                    'url' =>  $url
                ]);
            }
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
        if (auth()->user()->can('edit supplier')) {
            $supplier = Supplier::findOrFail($id);

            $title = array(
                'menu' => 'suppliers',
                'page' => 'Edit Supplier'
            );

            return view('tenants.suppliers.edit', compact(
                'title',
                'supplier'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(SupplierUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $supplier = Supplier::findOrFail($id);

            if ($request->hasFile('profile_avatar')) {
                $request['image'] = $request->file('profile_avatar')->store(tenant()->id . 'avatars');
            } else {
                $request['image'] = $supplier->image;
            }

            $supplier->update($request->except(['profile_avatar_remove', 'profile_avatar']));

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
        if (auth()->user()->can('remove supplier')) {
            DB::beginTransaction();

            try {
                $supplier = Supplier::findOrFail($id);

                $supplier->delete();

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
