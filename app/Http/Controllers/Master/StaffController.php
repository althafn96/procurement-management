<?php

namespace App\Http\Controllers\Master;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Staff\StaffStoreRequest;
use App\Http\Requests\Master\Staff\StaffUpdateRequest;
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
                return $usersDataTable->getAll('master');
            }

            return view('master.staff.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create staff')) {
            $title = array(
                'menu' => 'staff',
                'page' => 'Create Staff'
            );

            $roles = Role::ofType(auth()->user()->role->type)->where('status', '1')->get();

            return view('master.staff.create', compact(
                'title',
                'roles'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(StaffStoreRequest $request)
    {
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


            $user->details()->create($request->all());

            if ($request->has('permissions')) {
                $user->givePermissionTo($request->permissions);
            }

            DB::commit();

            $url = route('staff.index');

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

    public function edit($id)
    {
        if (auth()->user()->can('edit staff')) {
            $user = User::with('role')->findOrFail($id);

            if ($user->role->type != 'master') {
                return abort('404');
            }

            if ($user->role_id == '1' && auth()->user()->role->id != '1') {
                return abort('404');
            }

            $title = array(
                'menu' => 'staff',
                'page' => 'Edit Staff'
            );

            if (auth()->user()->role->id == '1') {
                $roles = Role::ofType(auth()->user()->role->type)->get();
            } else {
                $roles = Role::ofType(auth()->user()->role->type)->where('status', '1')->get();
            }
            $modules = DB::table('modules')->get();
            $permissions = Permission::get();

            return view('master.staff.edit', compact(
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

            if ($user->role->type != 'master') {
                return abort('404');
            }

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

        if ($user->role->name == 'Super Admin') {
            return abort('409', 'this user cannot be deleted');
        }

        if (auth()->user()->can('remove staff')) {
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
        } else {
            return abort('403');
        }
    }
}
