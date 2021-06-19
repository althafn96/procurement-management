<?php

namespace App\Http\Controllers\Tenants;

use Exception;
use Throwable;
use App\Models\User;
use App\Models\Project;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\ClientAdmin;
use Illuminate\Http\Request;
use App\Models\ClientCustomer;
use App\Models\OpportunityRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\DataTables\Tenants\ProjectsDataTable;
use App\Http\Requests\Tenants\Projects\ProjectStoreRequest;
use App\Http\Requests\Tenants\Projects\ProjectUpdateRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProjectsDataTable $projectsDataTable)
    {
        if (auth()->user()->can('view all projects')) {
            if ($request->has('type')) {
                if ($request->type == 'recent') {
                    $recentProjects = Project::with('assignedStaff')->latest()->limit(5)->get();

                    return response()->json($recentProjects, 200);
                } else {
                    return response()->json(null, 500);
                }
            }
            if ($request->has('searchTerm')) {
                $projects = Project::with('assignedStaff')->whereLike(['title', 'reference_no'], $request->searchTerm)->limit(10)->get();

                return response()->json($projects, 200);
            }

            $title = array(
                'menu' => 'projects',
                'page' => 'Projects'
            );

            if ($request->ajax()) {
                return $projectsDataTable->getProjects();
            }

            return view('tenants.projects.index', compact(
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
    public function create(Request $request)
    {
        return abort('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectStoreRequest $request)
    {
        if (auth()->user()->can('create project')) {
            $opportunityRequest = OpportunityRequest::findOrFail($request->request_id);

            DB::beginTransaction();

            try {
                if ($request->status == 'Accepted') {
                    tenant()->projects()->create(array_merge($request->except('_token', 'status', 'request_id'), ['opportunity_request_id' => $request->request_id]));

                    $msg = 'added to project successfully';
                } else {
                    $msg = 'rejected the request successfully';
                }

                $opportunityRequest->update([
                    'status' => $request->status
                ]);

                DB::commit();

                $url = route('opportunity-requests.index', tenant()->id);

                return response()->json([
                    'type' => 'success',
                    'url' =>  $url,
                    'msg' => $msg
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if (auth()->user()->can('view project')) {
            $title = array(
                'menu' => 'projects',
                'page' => 'View Project'
            );

            return view('tenants.projects.view', compact(
                'title',
                'project'
            ));
        } else {
            return abort('403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if (auth()->user()->can('edit project')) {
            $title = array(
                'menu' => 'projects',
                'page' => 'Edit Project'
            );

            $categories = Category::where('status', '1')->get();
            $suppliers = Supplier::where('status', '1')->get();
            $staff = ClientAdmin::where('tenant_id', tenant()->id)->get();
            $customers = ClientCustomer::get();

            return view('tenants.projects.edit', compact(
                'title',
                'categories',
                'suppliers',
                'customers',
                'staff',
                'project'
            ));
        } else {
            return abort('403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectUpdateRequest $request, Project $project)
    {
        if (auth()->user()->can('edit project')) {
            DB::beginTransaction();

            try {
                $project->update($request->except('_token'));

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if (auth()->user()->can('remove project')) {
            DB::beginTransaction();

            try {
                $project->delete();

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
        } else {
            return abort('403');
        }
    }
}
