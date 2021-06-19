<?php

namespace App\Http\Controllers\Tenants;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role->type == 'client_admin') {
            $title = array(
                'menu' => 'modules',
                'page' => 'Modules'
            );

            $modules = DB::table('modules')->where('type', 'client')->get();

            return view('tenant.modules.index', compact(
                'title'
            ));
        } else {
            return abort('404');
        }
    }
}
