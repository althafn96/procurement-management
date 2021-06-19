<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRole\UserRoleStoreRequest;
use App\Http\Requests\UserRole\UserRoleUpdateRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Throwable;

class UserRoleController extends Controller
{
    public function index(Request $request, UsersDataTable $usersDataTable)
    {
        if (auth()->user()->can('view all user roles')) {
            $title = array(
                'menu' => 'user-roles',
                'page' => 'User Roles'
            );

            if ($request->ajax()) {
                return $usersDataTable->getUserRoles();
            }

            return view('user-roles.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create user role')) {
            $title = array(
                'menu' => 'user-roles',
                'page' => 'Create User Role'
            );

            $modules = DB::table('modules')->where('type', auth()->user()->role->type)->orWhere('type', 'common')->get();

            $permissions = Permission::get();

            return view('user-roles.create', compact(
                'title',
                'modules',
                'permissions'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(UserRoleStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->type == 'master' ? 'master' . '-'. $request->role : tenant()->id . '-' .$request->role,
                'type' => $request->type,
                'tenant_id' => $request->type == 'master' ? null : tenant()->id
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            DB::commit();

            if ($request->type == 'master') {
                $url = url('/user-roles');
            } else {
                $url = url(tenant()->id. '/user-roles');
            }

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
        if (auth()->user()->can('edit user role')) {
            $user_role = Role::ofType(auth()->user()->role->type)->findOrFail($id);

            if ($user_role->name == 'Admin' || $user_role->name == 'Customer') {
                return abort('404');
            }

            if ($user_role->id == '1' && auth()->user()->role->id != '1') {
                return abort('404');
            }

            $title = array(
                'menu' => 'user-roles',
                'page' => 'Edit User Role'
            );

            $modules = DB::table('modules')->where('type', auth()->user()->role->type)->orWhere('type', 'common')->get();
            $permissions = Permission::get();

            return view('user-roles.edit', compact(
                'title',
                'user_role',
                'modules',
                'permissions'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(UserRoleUpdateRequest $request, $id)
    {
        $role = Role::ofType(auth()->user()->role->type)->findOrFail($id);

        DB::beginTransaction();

        try {
            $role->update([
                'name' => $request->type == 'master' ? 'master' . '-'. $request->role : tenant()->id . '-' .$request->role,
                'type' => $request->type,
                'tenant_id' => $request->type == 'master' ? null : tenant()->id
            ]);

            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

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
        if (auth()->user()->can('remove user role')) {
            $role = Role::ofType(auth()->user()->role->type)->findOrFail($id);

            if ($role->roleUsers->count() > 0) {
                return response('', 409);
            }

            if ($role->id == '1' && auth()->user()->role->id != '1') {
                return abort('404');
            }

            try {
                $role->forceDelete();

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
