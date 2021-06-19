<?php

namespace App\Http\Controllers\Master;

use App\DataTables\Master\PlansDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Plans\PlanStoreRequest;
use App\Http\Requests\Plans\PlanUpdateRequest;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class PlanController extends Controller
{
    public function index(Request $request, PlansDataTable $plansDataTable)
    {
        if(auth()->user()->can('view all plans')) {
            $title = array(
                'menu' => 'plans',
                'page' => 'Plans'
            );

            if($request->ajax()) {
                return $plansDataTable->getAll();
            }

            return view('master.plans.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if(auth()->user()->can('create plan')) {
            $title = array(
                'menu' => 'plans',
                'page' => 'Create plan'
            );

            return view('master.plans.create', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(PlanStoreRequest $request)
    {
        DB::beginTransaction();

        try {

            $plan = Plan::create($request->all());

            DB::commit();

            $url = route('plans.index');

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
        //
    }

    public function edit($id)
    {
        if(auth()->user()->can('edit plan')) {
            $plan = Plan::findOrFail($id);

            $title = array(
                'menu' => 'plans',
                'page' => 'Edit Plan'
            );

            return view('master.plans.edit', compact(
                'title',
                'plan',
            ));
        } else {
            return abort('403');
        }
    }

    public function update(PlanUpdateRequest $request, Plan $plan)
    {

        DB::beginTransaction();

        try {

            $plan->update($request->all());

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
        if(auth()->user()->can('remove plan')) {
            $plan = Plan::findOrFail($id);

            try {
                if($plan->clients->count() == 0) {
                    $plan->delete();
                } else {
                    return response('plan cannot be deleted', 409);
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
