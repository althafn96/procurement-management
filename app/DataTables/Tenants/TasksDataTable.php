<?php
namespace App\DataTables\Tenants;

use App\Models\Task;
use DataTables;

class TasksDataTable
{
    public function getTasks()
    {
        $tasks = Task::latest()->get();

        return DataTables::of($tasks)
                ->addColumn('pipeline', function ($task) {
                    return $task->pipeline == null ? '' : $task->pipeline->title;
                })
                ->addColumn('project', function ($task) {
                    return $task->pipeline == null ? '' : ($task->pipeline->project == null ? '' : $task->pipeline->project->opportunityRequest->title);
                })
                ->addColumn('pipeline', function ($task) {
                    return $task->pipeline == null ? '' : $task->pipeline->title;
                })
                ->addColumn('assigned_staff', function ($task) {
                    $output = '';
                    foreach ($task->assignedStaff as $assignedStaff) {
                        $output .= '<span class="status-badge label label-lg font-weight-bold label-secondary label-inline">'.$assignedStaff->full_name.'</span>';
                    }

                    return $output;
                })
                ->addColumn('action', function ($task) {
                })
                ->rawColumns(['assigned_staff'])
                ->make('true');
    }
}
