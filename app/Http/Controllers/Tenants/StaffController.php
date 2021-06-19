<?php

namespace App\Http\Controllers\Tenants;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\Staff\StaffStoreRequest;
use App\Http\Requests\Tenants\Staff\StaffUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Throwable;

class StaffController extends Controller
{
    public function index(Request $request, UsersDataTable $usersDataTable)
    {
        if (auth()->user()->can('view all staff')) {
            $title = array(
                'menu' => 'staff',
                'page' => 'Staff'
            );

            if ($request->ajax()) {
                if ($request->has('type') && $request->type == 'select2') {
                    $staffArr = array();

                    if ($request->has('search')) {
                        $staff = User::whereHas('role', function ($query) {
                            return $query->where('type', 'client')->where('id', '!=', '1');
                        })->whereHas('clients', function ($query) {
                            return $query->where('tenant_id', tenant()->id);
                        })->where('first_name', 'LIKE', '%'.$request->search.'%')->get();
                    } else {
                        $staff = User::whereHas('role', function ($query) {
                            return $query->where('type', 'client')->where('id', '!=', '1');
                        })->whereHas('clients', function ($query) {
                            return $query->where('tenant_id', tenant()->id);
                        })->get();
                    }

                    foreach ($staff as $singleStaff) {
                        array_push($staffArr, array('id' => $singleStaff->id, 'text' => $singleStaff->full_name, 'staff_id' => $singleStaff->details->id));
                    }

                    return response()->json([
            'results' => $staffArr
        ]);
                }
                return $usersDataTable->getAll('client');
            }

            return view('tenants.staff.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create staff')) {
            if (tenant()->admins->count() >= tenant()->plan->admins_count) {
                return redirect()->route('client-staff.index', [tenant()->id]);
            }

            $title = array(
                'menu' => 'staff',
                'page' => 'Create Staff'
            );

            $roles = Role::ofType(auth()->user()->role->type)->where('name', '!=', 'client-Customer')->where('status', '1')->get();

            return view('tenants.staff.create', compact(
                'title',
                'roles'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(StaffStoreRequest $request)
    {
        if (tenant()->admins->count() >= tenant()->plan->admins_count) {
            return abort('419', 'you have reached the maximum number of admins as per your plan. <br/> please purchase a higher plan to continue adding more admins.');
        }

        DB::beginTransaction();

        try {
            if ($request->hasFile('profile_avatar')) {
                $request['picture'] = $request->file('profile_avatar')->store('avatars');
            }

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id
            ]);

            $user->details()->create(array_merge($request->all(), ['tenant_id' => tenant()->id]));

            if ($request->has('permissions')) {
                $user->givePermissionTo($request->permissions);
            }

            DB::commit();

            $url = route('client-staff.index', tenant()->id);

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
        if (auth()->user()->can('edit staff')) {
            $user = User::with('role')->findOrFail($id);

            // if ($user->role->type != 'master') {
            //     return abort('404');
            // }

            if ($user->role_id == '1' && auth()->user()->role->id != '1') {
                return abort('404');
            }
            if ($user->role->name == 'Customer') {
                return abort('404');
            }

            $title = array(
                'menu' => 'staff',
                'page' => 'Edit Staff'
            );

            $roles = Role::ofType(auth()->user()->role->type)->where('status', '1')->get();

            $modules = DB::table('modules')->where('type', auth()->user()->role->type)->orWhere('type', 'common')->get();
            $permissions = Permission::get();

            return view('tenants.staff.edit', compact(
                'title',
                'user',
                'roles',
                'modules',
                'permissions'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(StaffUpdateRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $user = User::with('role')->findOrFail($id);

            // if($user->role->type != 'master') {
            //     return abort('404');
            // }

            if ($request->hasFile('profile_avatar')) {
                $request['picture'] = $request->file('profile_avatar')->store('avatars');
            }

            $user->update([
                'email' => $request->email,
                'password' => $request->password == '' ? $user->password : bcrypt($request->password)
            ]);

            $user->details()->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'image' => $request->hasFile('profile_avatar') ? $request->image : $user->details->image
            ]);

            $user->syncPermissions($request->permissions);

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
        $user = User::with('role')->findOrFail($id);

        if ($user->role->name == 'Admin') {
            return abort('409', 'this user cannot be deleted');
        }

        DB::beginTransaction();

        try {
            $user->details()->delete();
            $user->delete();

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
