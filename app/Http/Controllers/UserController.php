<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Exception;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index(Request $request, UsersDataTable $usersDataTable)
    {
        if (auth()->user()->can('view all staff')) {
            $title = array(
                'menu' => 'users',
                'page' => 'Staff'
            );

            if ($request->ajax()) {
                return $usersDataTable->getAll(auth()->user()->role->type);
            }

            return view('users.index', compact(
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
                'menu' => 'users',
                'page' => 'Create Staff'
            );

            $roles = Role::ofType(auth()->user()->role->type)->where('status', '1')->get();

            return view('users.create', compact(
                'title',
                'roles'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(UserStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('profile_avatar')) {
                $request['picture'] = $request->file('profile_avatar')->store('avatars');
            }
            // dd($request->except(['profile_avatar', 'profile_avatar_remove', 'password', 'permissions', 'role_id']));

            $user = User::create([
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id
            ]);


            $user->details()->create($request->except(['profile_avatar', 'profile_avatar_remove', 'password', 'permissions', 'role_id', 'email']));

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

    public function show($id)
    {
        return abort('404');
    }

    public function edit($id)
    {
        if (auth()->user()->can('edit staff')) {
            $user = User::findOrFail($id);

            if ($user->role_id == '1' && auth()->user()->role->id != '1') {
                return abort('404');
            }

            $title = array(
                'menu' => 'users',
                'page' => 'Edit Staff'
            );

            if (auth()->user()->role->id == '1') {
                $roles = Role::ofType(auth()->user()->role->type)->get();
            } else {
                $roles = Role::ofType(auth()->user()->role->type)->where('status', '1')->get();
            }
            $modules = DB::table('modules')->get();
            $permissions = Permission::get();

            return view('users.edit', compact(
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

    public function update(UserUpdateRequest $request, User $user)
    {
        DB::beginTransaction();

        try {
            if ($request->hasFile('profile_avatar')) {
                $request['picture'] = $request->file('profile_avatar')->store('avatars');
            }

            $user->update([
                'email' => $request->email,
                'password' => $request->password == '' ? $user->password : bcrypt($request->password)
            ]);

            $user->details()->update($request->except(['profile_avatar', 'profile_avatar_remove', 'password', 'permissions', 'role_id', 'email', '_method']));

            if ($request->has('permissions')) {
                $user->syncPermissions($request->permissions);
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
        if (auth()->user()->can('remove staff')) {
            $user = User::findOrFail($id);

            if ($user->role_id == '1') {
                return abort('404');
            }

            try {
                $user->delete();

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
