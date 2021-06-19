<?php

namespace App\Actions;

use Exception;
use Throwable;
use App\Models\Project;
use Illuminate\Http\Request;

class AddAttachment
{
    public function __invoke(Request $request)
    {
        try {
            $uploadedFile = $request->file->store('attachments');

            if ($request->type == 'project') {
                $project = Project::find(1);
                $project->attachments()->create([
                        'name' => $request->file('file')->getClientOriginalName(),
                        'extension' => $request->file('file')->getClientOriginalExtension(),
                        'tenant_id' => tenant('id'),
                        'url' => $uploadedFile
                    ]);
            } else {
                return response()->json('unknown error occurred.', 500);
            }

            return response()->json($uploadedFile, 201);
        } catch (Throwable $e) {
            return response()->json($e, 500);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
