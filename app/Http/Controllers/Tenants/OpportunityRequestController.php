<?php

namespace App\Http\Controllers\Tenants;

use App\DataTables\Tenants\OpportunitiesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tenants\OpportunityRequests\OpportunityRequestStoreRequest;
use App\Http\Requests\Tenants\OpportunityRequests\OpportunityRequestUpdateRequest;
use App\Models\Category;
use App\Models\ClientAdmin;
use App\Models\ClientCustomer;
use App\Models\OpportunityRequest;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OpportunityRequestController extends Controller
{
    public function index(Request $request, OpportunitiesDataTable $opportunitiesDataTable)
    {
        if (auth()->user()->can('view all opportunity requests')) {
            $title = array(
                'menu' => 'opportunity-requests',
                'page' => 'Opportunity Requests'
            );

            if ($request->ajax()) {
                return $opportunitiesDataTable->getRequests();
            }


            $categories = Category::where('status', '1')->get();
            $suppliers = Supplier::where('status', '1')->get();
            $staff = ClientAdmin::where('tenant_id', tenant()->id)->get();

            return view('tenants.oppurtunity_requests.index', compact(
                'title',
                'staff',
                'suppliers',
                'categories'
            ));
        } else {
            return abort('403');
        }
    }

    public function create()
    {
        if (auth()->user()->can('create opportunity request')) {
            $title = array(
                'menu' => 'opportunity-requests',
                'page' => 'Create Opportunity Request'
            );

            $categories = Category::where('status', '1')->get();
            $suppliers = Supplier::where('status', '1')->get();
            $customers = ClientCustomer::whereDoesntHave('user')->get();

            return view('tenants.oppurtunity_requests.create', compact(
                'title',
                'categories',
                'suppliers',
                'customers'
            ));
        } else {
            return abort('403');
        }
    }

    public function store(OpportunityRequestStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            tenant()->opportunityRequests()->create($request->all());

            DB::commit();

            $url = route('opportunity-requests.index', tenant()->id);

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

    public function edit($id)
    {
        if (auth()->user()->can('edit opportunity request')) {
            $opportunity_request = OpportunityRequest::findOrFail($id);

            $title = array(
                'menu' => 'opportunity-requests',
                'page' => 'Edit Opportunity Request'
            );

            $categories = Category::where('status', '1')->get();
            $suppliers = Supplier::where('status', '1')->get();
            $customers = ClientCustomer::whereDoesntHave('user')->get();

            return view('tenants.oppurtunity_requests.edit', compact(
                'title',
                'categories',
                'suppliers',
                'customers',
                'opportunity_request'
            ));
        } else {
            return abort('403');
        }
    }

    public function update(OpportunityRequestUpdateRequest $request, $id)
    {
        $opportunity_request = OpportunityRequest::findOrFail($id);

        DB::beginTransaction();

        try {
            $opportunity_request->update($request->all());

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
        if (auth()->user()->can('remove opportunity request')) {
            $opportunity_request = OpportunityRequest::findOrFail($id);

            DB::beginTransaction();

            try {
                $opportunity_request->delete();

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
