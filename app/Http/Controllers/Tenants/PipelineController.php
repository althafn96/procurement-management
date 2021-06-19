<?php

namespace App\Http\Controllers\Tenants;

use Exception;
use Throwable;
use App\Models\Project;
use App\Models\Pipeline;
use App\Models\ClientAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\DataTables\Tenants\PipelinesDataTable;

class PipelineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, PipelinesDataTable $pipelinesDataTable)
    {
        if (auth()->user()->can('view all pipelines')) {
            $title = array(
                'menu' => 'pipelines',
                'page' => 'Pipelines'
            );

            if ($request->has('project_id')) {
                $pipeline = Pipeline::with('assignedStaff')->where('project_id', $request->project_id)->get();

                return response()->json($pipeline, 200);
            }

            if ($request->ajax()) {
                return $pipelinesDataTable->getPipelines();
            }

            return view('tenants.pipelines.index', compact(
                'title'
            ));
        } else {
            return abort('403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->can('create pipeline')) {
            $title = array(
                'menu' => 'pielines',
                'page' => 'Create Pipeline'
            );

            $projects = Project::where('status', '!=', 'Done')->get();
            $staff = ClientAdmin::where('tenant_id', tenant()->id)->get();

            return view('tenants.pipelines.create', compact(
                'title',
                'projects',
                'staff'
            ));
        } else {
            return abort('403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $pipeline = tenant()->pipelines()->create($request->except('assigned_staff_ids'));

            $pipeline->assignedStaff()->sync($request->assigned_staff_ids);

            DB::commit();

            $url = route('pipelines.index', tenant()->id);

            return response()->json([
                'type' => 'success',
                'url' =>  $url,
                'pipeline' => $pipeline
            ], 201);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ], 500);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pipeline  $pipeline
     * @return \Illuminate\Http\Response
     */
    public function show(Pipeline $pipeline)
    {
        return abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pipeline  $pipeline
     * @return \Illuminate\Http\Response
     */
    public function edit(Pipeline $pipeline)
    {
        if (auth()->user()->can('create pipeline')) {
            $title = array(
                'menu' => 'pielines',
                'page' => 'Edit Pipeline'
            );

            $projects = Project::where('status', '!=', 'Done')->get();
            $staff = ClientAdmin::where('tenant_id', tenant()->id)->get();

            return view('tenants.pipelines.edit', compact(
                'title',
                'projects',
                'pipeline',
                'staff'
            ));
        } else {
            return abort('403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pipeline  $pipeline
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pipeline $pipeline)
    {
        DB::beginTransaction();

        try {
            $pipeline->update($request->except('assigned_staff_ids'));

            $pipeline->assignedStaff()->sync($request->assigned_staff_ids);

            DB::commit();

            return response()->json([
                'type' => 'success',
                'pipeline' => $pipeline
            ], 202);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ], 500);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json([
                'type' => 'error',
                'text' => 'unknown error occurred. please try again later',
                'errorMsg' => $e
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pipeline  $pipeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pipeline $pipeline)
    {
        if (auth()->user()->can('remove pipeline')) {
            DB::beginTransaction();

            try {
                $pipeline->delete();

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
