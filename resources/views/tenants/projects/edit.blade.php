<x-app-layout :title="$title">

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h2 class="text-white font-weight-bold my-2 mr-5">Projects</h2>
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
                            <a href="{{ route('projects.index', [tenant()->id]) }}" class="text-white text-hover-white opacity-75 hover-opacity-100">Projects</a>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Edit Project</a>
                            <!--end::Item-->
                        </div>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom card-sticky" id="kt_page_sticky_card">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">
                                &nbsp;
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <a href="{{ url()->previous() }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn">
                                <i class="ki ki-long-arrow-back icon-sm"></i>
                                Back
                            </a>
                            <button form="kt_project_update_form" id="kt_project_update_btn" type="submit"
                                class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Update Project
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Form-->
                        <form action="{{ route('projects.update', ['tenant'=>tenant()->id, 'project' => $project]) }}" method="POST" class="form" id="kt_project_update_form">
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="my-5">
                                        <div class="form-group row">
                                            <label class="col-3">Reference No.</label>
                                            <div class="col-9">
                                                <input value="{{ $project->reference_no }}"  id="reference_no" class="form-control form-control-solid" type="text" name="reference_no" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Title</label>
                                            <div class="col-9">
                                                <input value="{{ $project->title }}" id="title" class="form-control form-control-solid" type="text" name="title" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Description</label>
                                            <div class="col-9">
                                                <textarea class="form-control form-control-solid" name="description" id="" cols="15" rows="5">{{ $project->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">CPV Code</label>
                                            <div class="col-9">
                                                <input value="{{ $project->cpv_code }}"  id="cpv_code" class="form-control form-control-solid" type="text" name="cpv_code" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">SME Friendly</label>
                                            <div class="col-9">
                                                <input value="{{ $project->sme_friendly }}" id="sme_friendly" class="form-control form-control-solid" type="text" name="sme_friendly" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Allocate</label>
                                            <div class="col-9">
                                                <input value="{{ $project->allocate }}" class="form-control form-control-solid" type="number" name="allocate" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Estimated Budget</label>
                                            <div class="col-9">
                                                <input value="{{ $project->estimated_budget }}"  class="form-control form-control-solid" type="number" name="estimated_budget" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Supplier</label>
                                            <div class="col-9">
                                                <select id="supplier_id" name="supplier_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option {{ $project->supplier_id == $supplier->id ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Contract Start Date</label>
                                            <div class="col-9">
                                                <input value="{{ $project->start_date }}" class="form-control form-control-solid" type="date" name="start_date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Contract End Date</label>
                                            <div class="col-9">
                                                <input value="{{ $project->end_date }}" class="form-control form-control-solid" type="date" name="end_date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Category</label>
                                            <div class="col-9">
                                                <select name="category_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($categories as $category)
                                                        <option {{ $project->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }} ({{ $category->code }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Social Value Act</label>
                                            <div class="col-9">
                                                <select id="social_value_act" name="social_value_act" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                        <option {{ $project->social_value_act == 'Y' ? 'selected' : '' }} value="Y">Yes</option>
                                                        <option {{ $project->social_value_act == 'N' ? 'selected' : '' }} value="N">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Finance Advisor</label>
                                            <div class="col-9">
                                                <input value="{{ $project->finance_advisor }}" id="finance_advisor" class="form-control form-control-solid" type="text" name="finance_advisor" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Legal Advisor</label>
                                            <div class="col-9">
                                                <input value="{{ $project->legal_advisor }}" id="legal_advisor" class="form-control form-control-solid" type="text" name="legal_advisor" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Other Advisors</label>
                                            <div class="col-9">
                                                <input value="{{ $project->other_advisors }}" id="other_advisors" class="form-control form-control-solid" type="text" name="other_advisors" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Project Priority</label>
                                            <div class="col-9">
                                                <select id="project_priority" name="project_priority" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                        <option {{ $project->project_priority == 'High' ? 'selected' : '' }} value="High">High</option>
                                                        <option {{ $project->project_priority == 'Medium' ? 'selected' : '' }} value="Medium">Medium</option>
                                                        <option {{ $project->project_priority == 'Low' ? 'selected' : '' }} value="Low">Low</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">RAG Status</label>
                                            <div class="col-9">
                                                <select id="rag_status" name="rag_status" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                        <option {{ $project->rag_status == 'Red' ? 'selected' : '' }} value="Red">Red</option>
                                                        <option {{ $project->rag_status == 'Amber' ? 'selected' : '' }} value="Amber">Amber</option>
                                                        <option {{ $project->rag_status == 'Green' ? 'selected' : '' }} value="Green">Green</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Assigned to</label>
                                            <div class="col-9">
                                                <select name="assigned_staff_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($staff as $single_staff)
                                                        <option {{ $project->assigned_staff_id == $single_staff->id ? 'selected' : '' }} value="{{ $single_staff->id }}">{{ $single_staff->first_name }} {{ $single_staff->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

    <x-slot name="scripts">
        <script src="{{ global_asset('assets/tenants/js/projects.js') }}"></script>
    </x-slot>

</x-app-layout>
