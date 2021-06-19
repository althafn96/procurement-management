<x-app-layout :title="$title">
    <x-slot name="styles">
        <link href="{{ global_asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h2 class="text-white font-weight-bold my-2 mr-5">Opportunity Requests</h2>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <div class="d-flex align-items-center font-weight-bold my-2">
                            <!--begin::Item-->
                            <a href="#" class="opacity-75 hover-opacity-100">
                                <i class="flaticon2-shelter text-white icon-1x"></i>
                            </a>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Opportunity Requests</a>
                            <!--end::Item-->

                        </div>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->

                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <span class="card-icon">
                                <i class="flaticon2-graphic text-primary"></i> &nbsp;
                            </span>
                            <h3 class="card-label">All Opportunity Requests
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            @can('create opportunity request')
                            <!--begin::Button-->
                            <a href="{{ route('opportunity-requests.create', [tenant()->id]) }}" class="btn btn-primary font-weight-bold btn-sm create-btn"><i class="ki ki-plus icon-sm"></i>Create Request</a>
                            <!--end::Button-->
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table
                        data-url="{{ route('opportunity-requests.index', [tenant()->id]) }}"
                        data-edit="{{ auth()->user()->can('edit opportunity request') }}"
                        data-remove="{{ auth()->user()->can('remove opportunity request') }}"
                        data-acceptorreject="{{ auth()->user()->can('accept or reject opportunity request') }}"
                        class="table table-separate table-head-custom collapsed"
                        id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Stakeholder</th>
                                    <th>Estimated Budget</th>
                                    <th>Current Value</th>
                                    <th>Savings</th>
                                    <th>Supplier</th>
                                    <th>Description</th>
                                    <th>Contract End Date</th>
                                    <th>Contract Start Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Stakeholder</th>
                                    <th>Estimated Budget</th>
                                    <th>Current Value</th>
                                    <th>Savings</th>
                                    <th>Supplier</th>
                                    <th>Description</th>
                                    <th>Contract End Date</th>
                                    <th>Contract Start Date</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

    <div class="modal fade" id="requestReceive" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestReceiveLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('projects.store', [tenant()]) }}" method="POST" class="form" id="kt_project_add_form">
                        @csrf
                        <input type="hidden" name="request_id">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="my-5">
                                    <div class="form-group row">
                                        <label class="col-3">Status</label>
                                        <div class="col-9">
                                            <select name="status" class="form-control form-control-solid kt-selectpicker">
                                                <option value=""></option>
                                                <option value="Accepted">Accept</option>
                                                <option value="Rejected">Reject</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Reference No.</label>
                                        <div class="col-9">
                                            <input id="reference_no" class="form-control form-control-solid" type="text" name="reference_no" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Title</label>
                                        <div class="col-9">
                                            <input id="title" class="form-control form-control-solid" type="text" name="title" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Description</label>
                                        <div class="col-9">
                                            <textarea class="form-control form-control-solid" name="description" id="" cols="15" rows="5"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">CPV Code</label>
                                        <div class="col-9">
                                            <input id="cpv_code" class="form-control form-control-solid" type="text" name="cpv_code" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">SME Friendly</label>
                                        <div class="col-9">
                                            <input id="sme_friendly" class="form-control form-control-solid" type="text" name="sme_friendly" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Allocate</label>
                                        <div class="col-9">
                                            <input class="form-control form-control-solid" type="number" name="allocate" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Estimated Budget</label>
                                        <div class="col-9">
                                            <input class="form-control form-control-solid" type="number" name="estimated_budget" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Supplier</label>
                                        <div class="col-9">
                                            <select id="supplier_id" name="supplier_id" class="form-control form-control-solid kt-selectpicker">
                                                <option value=""></option>
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Contract Start Date</label>
                                        <div class="col-9">
                                            <input class="form-control form-control-solid" type="date" name="start_date" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Contract End Date</label>
                                        <div class="col-9">
                                            <input class="form-control form-control-solid" type="date" name="end_date" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Category</label>
                                        <div class="col-9">
                                            <select name="category_id" class="form-control form-control-solid kt-selectpicker">
                                                <option value=""></option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }} ({{ $category->code }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Social Value Act</label>
                                        <div class="col-9">
                                            <select id="social_value_act" name="social_value_act" class="form-control form-control-solid kt-selectpicker">
                                                <option value=""></option>
                                                    <option value="Y">Yes</option>
                                                    <option value="N">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Finance Advisor</label>
                                        <div class="col-9">
                                            <input id="finance_advisor" class="form-control form-control-solid" type="text" name="finance_advisor" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Legal Advisor</label>
                                        <div class="col-9">
                                            <input id="legal_advisor" class="form-control form-control-solid" type="text" name="legal_advisor" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Other Advisors</label>
                                        <div class="col-9">
                                            <input id="other_advisors" class="form-control form-control-solid" type="text" name="other_advisors" />
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Project Priority</label>
                                        <div class="col-9">
                                            <select id="project_priority" name="project_priority" class="form-control form-control-solid kt-selectpicker">
                                                <option value=""></option>
                                                    <option value="High">High</option>
                                                    <option value="Medium">Medium</option>
                                                    <option value="Low">Low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">RAG Status</label>
                                        <div class="col-9">
                                            <select id="rag_status" name="rag_status" class="form-control form-control-solid kt-selectpicker">
                                                <option value=""></option>
                                                    <option value="Red">Red</option>
                                                    <option value="Amber">Amber</option>
                                                    <option value="Green">Green</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row assigning_user_field">
                                        <label class="col-3">Assign to</label>
                                        <div class="col-9">
                                            <select name="assigned_staff_id" class="form-control form-control-solid kt-selectpicker">
                                                <option value=""></option>
                                                @foreach ($staff as $single_staff)
                                                    <option value="{{ $single_staff->id }}">{{ $single_staff->first_name }} {{ $single_staff->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button form="kt_project_add_form" id="kt_project_add_btn" type="submit" class="btn btn-primary font-weight-bold">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ global_asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ global_asset('assets/tenants/js/opportunity_requests.js') }}"></script>
    </x-slot>
</x-app-layout>
