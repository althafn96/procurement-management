<?php

namespace App\Actions\Tasks;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsAction;

class LoadPipelinesToProject
{
    use AsAction;

    public function handle($project)
    {
        $output = '';

        foreach ($project->pipelines as $pipeline) {
            $output .= '<option value="'.$pipeline->id.'">'.$pipeline->title.'</option>';
        }

        return $output;
    }

    public function asController(Request $request, $id)
    {
        $project = Project::with('pipelines')->findOrFail($id);

        return $this->handle($project);
    }

    public function htmlResponse(String $output, Request $request) : Response
    {
        return response($output, 200);
    }
}
