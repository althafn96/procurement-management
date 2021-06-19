<?php

namespace App\Http\Controllers\Tenants;

use Exception;
use Throwable;
use App\Models\Task;
use App\Models\Project;
use App\Models\Pipeline;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->id) {
            if ($request->type == 'project') {
                $project = Project::findOrFail($request->id);

                return response()->json($project->attachments, 200);
            } elseif ($request->type == 'pipeline') {
                $pipeline = Pipeline::findOrFail($request->id);

                return response()->json($pipeline->attachments, 200);
            } elseif ($request->type == 'task') {
                $task = Task::findOrFail($request->id);

                return response()->json($task->attachments, 200);
            } else {
                return response()->json(null, 500);
            }
        } else {
            return response()->json(null, 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $uploadedFile = $request->file->store('attachments');

            if ($request->id) {
                if ($request->type == 'project') {
                    $project = Project::find($request->id);
                    $project->attachments()->create([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'extension' => $request->file('file')->getClientOriginalExtension(),
                            'tenant_id' => tenant('id'),
                            'url' => $uploadedFile
                        ]);
                } elseif ($request->type == 'pipeline') {
                    $pipeline = Pipeline::findOrFail($request->id);
                    $pipeline->attachments()->create([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'extension' => $request->file('file')->getClientOriginalExtension(),
                            'tenant_id' => tenant('id'),
                            'url' => $uploadedFile
                        ]);
                } elseif ($request->type == 'task') {
                    $task = Task::findOrFail($request->id);
                    $task->attachments()->create([
                            'name' => $request->file('file')->getClientOriginalName(),
                            'extension' => $request->file('file')->getClientOriginalExtension(),
                            'tenant_id' => tenant('id'),
                            'url' => $uploadedFile
                        ]);
                } else {
                    return response()->json('unknown error occurred.', 500);
                }

                return response()->json($uploadedFile, 201);
            } else {
                return response()->json(null, 500);
            }
        } catch (Throwable $e) {
            return response()->json($e, 500);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $attachment = Attachment::findOrFail($id);

            $attachment->delete();

            Storage::delete($attachment->url);

            DB::commit();
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
}
