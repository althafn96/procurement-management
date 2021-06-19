<?php
namespace App\DataTables;

use App\Models\Role;
use App\Models\User;
use DataTables;

class UsersDataTable
{
    public function getAll($type)
    {
        $users = User::whereHas('role', function ($query) use ($type) {
            return $query->where('type', $type)->where('id', '!=', '1');
        });

        if ($type == 'client') {
            $users = $users->whereHas('clients', function ($query) {
                return $query->where('tenant_id', tenant()->id);
            });
        }

        $users = $users->get();

        return DataTables::of($users)
                ->addColumn('name', function ($user) {
                    return '
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-40 symbol-sm flex-shrink-0">
                            <img class="" src="'.$user->image().'" alt="photo">
                        </div>
                        <div class="ml-4">
                            <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">'.$user->full_name.'</div>
                            <a href="#" onclick="return false;" class="text-muted font-weight-bold text-hover-primary">'.$user->email.'</a>
                        </div>
                    </div>
                    ';
                })
                ->addColumn('image', function ($user) {
                    return '<div class="symbol symbol-40 symbol-sm flex-shrink-0"><img class="" src="'.$user->image().'" alt="photo"></div>';
                })
                ->addColumn('action', function ($user) {
                })
                ->addColumn('status', function ($user) {
                    return $user->status;
                })
                ->addColumn('role', function ($user) {
                    return $user->role->name;
                })
                ->rawColumns(['name', 'action'])
                ->make('true');
    }

    public function getUserRoles()
    {
        $role_type = auth()->user()->role->type;
        $user_roles = Role::ofType($role_type)->where('status', '1');

        if ($role_type == 'client') {
            $user_roles = $user_roles->where('tenant_id', tenant()->id);
        }

        $user_roles = $user_roles->get();

        return DataTables::of($user_roles)
                ->addColumn('action', function ($user_role) {
                })
                ->addColumn('status', function ($user_role) {
                    return '1';
                })
                ->make('true');
    }
}
