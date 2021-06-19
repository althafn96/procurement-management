<?php

namespace App\Actions\Users;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Response;

class LoadPermissionsToRole
{
    use AsAction;

    public function handle($modules, $permissions, $role)
    {
        $output = '';

        foreach ($modules as $module) {
            $output .= '
            <div class="form-group row">
                <label class="col-3 col-form-label">'. ucfirst($module->name) .'</label>
                <div class="col-9 col-form-label">
                    <div class="checkbox-list">
            ';

            foreach ($permissions as $permission) {
                if ($permission->module_id == $module->id) {
                    $checked = '';

                    if ($role->hasPermissionTo($permission->name)) {
                        $checked = 'checked';
                    }

                    $output .= '
                        <label class="checkbox">
                            <input '. $checked .' type="checkbox" value="'.  $permission->name .'" name="permissions[]"><span></span>'.  $permission->name .'
                        </label>
                    ';
                }
            }

            $output .= '</div>
                    </div>
                </div>
            ';
        }

        return $output;
    }

    public function asController(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $modules = DB::table('modules')->where('type', auth()->user()->role->type)->orWhere('type', 'common')->get();
        $permissions = Permission::get();

        return $this->handle($modules, $permissions, $role);
    }

    public function htmlResponse(String $output, Request $request) : Response
    {
        return response($output, 200);
    }
}
