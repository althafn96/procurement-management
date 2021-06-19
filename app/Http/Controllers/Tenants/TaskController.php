<?php

namespace App\Http\Controllers\Tenants;

use Exception;
use Throwable;
use App\Models\Task;
use App\Models\Project;
use App\Models\Pipeline;
use App\Models\ClientAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\DataTables\Tenants\TasksDataTable;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TasksDataTable $tasksDataTable)
    {
        if (auth()->user()->can('view all tasks')) {
            $title = array(
                'menu' => 'tasks',
                'page' => 'Tasks'
            );

            if ($request->has('pipeline_id')) {
                $pipeline = Pipeline::findOrFail($request->pipeline_id);

                return response()->json($pipeline->tasks, 200);
            }

            if ($request->ajax()) {
                return $tasksDataTable->getTasks();
            }

            return view('tenants.tasks.index', compact(
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
        if (auth()->user()->can('create task')) {
            $title = array(
                'menu' => 'tasks',
                'page' => 'Create Task'
            );

            $projects = Project::where('status', '!=', 'Done')->get();
            $staff = ClientAdmin::where('tenant_id', tenant()->id)->get();

            return view('tenants.tasks.create', compact(
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
            // $task = tenant()->tasks()->create($request->except('assigned_staff_ids', 'project_id'));

            // $task->assignedStaff()->sync($request->assigned_staff_ids);
            if ($request->type == 'pipeline') {
                $pipeline = Pipeline::findOrFail($request->id);

                $task = $pipeline->tasks()->create(array_merge($request->except('assigned_staff_ids', 'id', 'type', '_method'), ['tenant_id' => tenant('id')]));

                $task->assignedStaff()->sync($request->assigned_staff_ids);
            }

            DB::commit();

            $url = route('tasks.index', tenant()->id);

            return response()->json([
                'type' => 'success',
                'url' =>  $url,
                'task' => $task
            ], 200);
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
    public function show(Task $task)
    {
        return abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pipeline  $pipeline
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        if (auth()->user()->can('create task')) {
            $title = array(
                'menu' => 'tasks',
                'page' => 'Edit Task'
            );

            $projects = Project::where('status', '!=', 'Done')->get();
            $staff = ClientAdmin::where('tenant_id', tenant()->id)->get();

            return view('tenants.tasks.edit', compact(
                'title',
                'projects',
                'task',
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
    public function update(Request $request, Task $task)
    {
        DB::beginTransaction();

        try {
            $task->update($request->except('assigned_staff_ids', 'project_id'));

            $task->assignedStaff()->sync($request->assigned_staff_ids);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pipeline  $pipeline
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if (auth()->user()->can('remove task')) {
            DB::beginTransaction();

            try {
                $task->delete();

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
