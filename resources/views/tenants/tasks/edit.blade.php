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
                        <h2 class="text-white font-weight-bold my-2 mr-5">Tasks</h2>
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
                            <a href="{{ route('tasks.index', [tenant()->id]) }}" class="text-white text-hover-white opacity-75 hover-opacity-100">Tasks</a>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Edit Task</a>
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
                            <a href="{{ route('tasks.index', [tenant()->id]) }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn">
                                <i class="ki ki-long-arrow-back icon-sm"></i>
                                Back
                            </a>
                            <button form="kt_task_update_form" id="kt_task_update_btn" type="submit"
                                class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Update Task
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('tasks.update', ['tenant' => tenant()->id, 'task' => $task]) }}" class="form" id="kt_task_update_form">
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">Task Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Title</label>
                                            <div class="col-9">
                                                <input value="{{ $task->title }}" class="form-control form-control-solid" type="text" name="title" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Project</label>
                                            <div class="col-9">
                                                <select id="project_id" name="project_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($projects as $project)
                                                        @php
                                                            $project_id = $task->pipeline->project->id ?? '';
                                                        @endphp
                                                        <option {{ $project_id == $project->id ? 'selected' : '' }} value="{{ $project->id }}">{{ $project->opportunityRequest->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Pipeline</label>
                                            <div class="col-9">
                                                <select id="pipeline_id" name="pipeline_id" class="form-control form-control-solid kt-selectpicker">
                                                    @foreach ($project->pipelines as $pipeline)
                                                        <option {{ $task->pipeline_id == $pipeline->id ? 'selected' : '' }} value="{{ $pipeline->id }}">{{ $pipeline->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Start Date</label>
                                            <div class="col-9">
                                                <input value="{{ $task->start_date }}" class="form-control form-control-solid" type="date" name="start_date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">End Date</label>
                                            <div class="col-9">
                                                <input value="{{ $task->end_date }}" class="form-control form-control-solid" type="date" name="end_date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Assign to</label>
                                            <div class="col-9">
                                                <select id="assigned_staff_id" name="assigned_staff_ids[]" multiple="multiple" class="form-control form-control-solid kt-selectpicker">
                                                    @foreach ($staff as $single_staff)
                                                        <option {{ in_array($single_staff->id, $task->assignedStaff->pluck('id')->toArray()) ? 'selected' : '' }} value="{{ $single_staff->id }}">{{ $single_staff->first_name }} {{ $single_staff->last_name }}</option>
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
        <script src="{{ global_asset('assets/tenants/js/tasks.js') }}"></script>
    </x-slot>

</x-app-layout>