<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Master\PlansDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Plans\PlanStoreRequest;
use App\Http\Requests\Plans\PlanUpdateRequest;
use App\Models\Module;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ModuleController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->can('view all modules')) {
            $title = array(
                'menu' => 'modules',
                'page' => 'Modules'
            );

            return view('master.modules.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create module')) {
            $title = array(
                'menu' => 'modules',
                'page' => 'Create Module'
            );

            return view('master.modules.create', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(ModuleStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $module = Module::create($request->all());

            DB::commit();

            $url = route('modules.index');

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
        if (auth()->user()->can('edit module')) {
            $module = Module::findOrFail($id);

            $title = array(
                'menu' => 'modules',
                'page' => 'Edit Module'
            );

            return view('master.modules.edit', compact(
                'title',
                'module',
            ));
        } else {
            return abort('403');
        }
    }

    public function update(ModuleUpdateRequest $request, Module $module)
    {
        DB::beginTransaction();

        try {
            $module->update($request->all());

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
        if (auth()->user()->can('remove module')) {
            $module = Module::findOrFail($id);

            try {
                if ($module->permissions->count() == 0) {
                    $module->delete();
                } else {
                    return response('module cannot be deleted', 409);
                }

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
