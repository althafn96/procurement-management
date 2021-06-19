<?php
namespace App\DataTables\Tenants;

use App\Models\Pipeline;
use DataTables;

class PipelinesDataTable
{
    public function getPipelines()
    {
        $pipelines = Pipeline::latest()->get();

        return DataTables::of($pipelines)
                ->addColumn('project', function ($pipeline) {
                    return $pipeline->project == null ? '' : ($pipeline->project->opportunityRequest == null ? '' : $pipeline->project->opportunityRequest->title);
                })
                ->addColumn('supplier', function ($pipeline) {
                    return '';
                })
                ->addColumn('customer', function ($pipeline) {
                    return '';
                })
                ->addColumn('assigned_staff', function ($pipeline) {
                    $output = '';
                    foreach ($pipeline->assignedStaff as $assignedStaff) {
                        $output .= '<span class="status-badge label label-lg font-weight-bold label-secondary label-inline">'.$assignedStaff->full_name.'</span>';
                    }

                    return $output;
                })
                ->addColumn('action', function ($pipeline) {
                })
                ->rawColumns(['assigned_staff'])
                ->make('true');
    }
}
