<?php
namespace App\DataTables\Tenants;

use App\Models\Project;
use DataTables;

class ProjectsDataTable
{
    public function getProjects()
    {
        $project = Project::latest()->get();

        return DataTables::of($project)
                ->addColumn('action', function ($project) {
                })
                ->addColumn('category', function ($project) {
                    return $project->category == null ? '' : $project->category->code;
                })
                ->addColumn('supplier', function ($project) {
                    return $project->supplier == null ? '' : $project->supplier->full_name;
                })
                ->addColumn('customer', function ($project) {
                    return $project->opportunityRequest->customer->full_name;
                })
                ->addColumn('assigned_to', function ($project) {
                    return $project->assignedStaff->full_name;
                })
                ->make('true');
    }
}
