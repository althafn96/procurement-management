<x-app-layout :title="$title">
    <x-slot name="styles">
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
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">View Project</a>
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
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <div class="d-flex">
                            <!--begin: Info-->
                            <div class="flex-grow-1">
                                <!--begin: Title-->
                                <div class="d-flex align-items-center justify-content-between flex-wrap">
                                    <div class="mr-3">
                                        <!--begin::Name-->
                                        <a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $project->title }}
                                        <!--end::Name-->
                                        <!--begin::Contacts-->
                                        <div class="d-flex flex-wrap my-2">
                                            <a href="#" onclick="return false;" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                Ref No:
                                            </span>{{ $project->reference_no }}</a>
                                            <a href="#" onclick="return false;" class="text-muted text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2">
                                            <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                Priority:
                                            </span>{{ $project->project_priority }}</a>
                                            <a href="#" onclick="return false;" class="text-muted text-hover-primary font-weight-bold">
                                            <span class="svg-icon svg-icon-md svg-icon-gray-500 mr-1">
                                                Category:
                                            </span>{{ $project->category->code }}</a>
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                    <div class="my-lg-0 my-1">
                                        <a href="{{ route('projects.index', ['tenant' => tenant('id')]) }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-3 back-btn">
                                            <i class="ki ki-long-arrow-back icon-sm"></i>
                                            Back
                                        </a>
                                        <a href="{{ route('projects.edit', ['project' => $project, 'tenant' => tenant('id')]) }}" class="btn btn-sm btn-light-warning font-weight-bolder text-uppercase mr-3">Edit</a>
                                    </div>
                                </div>
                                <!--end: Title-->
                                <!--begin: Content-->
                                <div class="d-flex align-items-center flex-wrap justify-content-between">
                                    <div class="flex-grow-1 font-weight-bold text-dark-50 py-5 py-lg-2 mr-5">
                                        {{ $project->description }}
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center py-2">
                                        <div class="d-flex align-items-center mr-10">
                                            <div class="mr-6">
                                                @if ($project->start_date)
                                                    <div class="font-weight-bold mb-2">Start Date</div>
                                                    <span class="btn btn-sm btn-text btn-light-primary text-uppercase font-weight-bold">{{ $project->start_date->format('d M, Y') }}</span>
                                                @endif
                                            </div>
                                            <div class="">
                                                @if ($project->end_date)
                                                    <div class="font-weight-bold mb-2">End Date</div>
                                                    <span class="btn btn-sm btn-text btn-light-danger text-uppercase font-weight-bold">{{ $project->end_date->format('d M, Y') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 flex-shrink-0 w-150px w-xl-300px mt-4 mt-sm-0">
                                            <span class="font-weight-bold">Progress</span>
                                            <div class="progress progress-xs mt-2 mb-2">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 63%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <span class="font-weight-bolder text-dark">78%</span>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Content-->
                            </div>
                            <!--end: Info-->
                        </div>
                        <div class="separator separator-solid my-7"></div>
                        <!--begin: Items-->
                        <div class="d-flex align-items-center flex-wrap">
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                <span class="mr-4">
                                    <i class="flaticon-piggy-bank icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="d-flex flex-column text-dark-75">
                                    <span class="font-weight-bolder font-size-sm">Savings</span>
                                    <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold">{{ config('app.currency') }}</span>{{ $project->savings }}</span>
                                </div>
                            </div>
                            <!--end: Item-->
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                <span class="mr-4">
                                    <i class="flaticon-confetti icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="d-flex flex-column text-dark-75">
                                    <span class="font-weight-bolder font-size-sm">Estimated</span>
                                    <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold">{{ config('app.currency') }}</span>{{ $project->estimated_budget }}</span>
                                </div>
                            </div>
                            <!--end: Item-->
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                <span class="mr-4">
                                    <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="d-flex flex-column text-dark-75">
                                    <span class="font-weight-bolder font-size-sm">Allocated</span>
                                    <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold">{{ config('app.currency') }}</span>{{ $project->allocate }}</span>
                                </div>
                            </div>
                            <!--end: Item-->
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                <span class="mr-4">
                                    <i class="flaticon-pie-chart icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="d-flex flex-column text-dark-75">
                                    <span class="font-weight-bolder font-size-sm">Current Value</span>
                                    <span class="font-weight-bolder font-size-h5">
                                    <span class="text-dark-50 font-weight-bold">{{ config('app.currency') }}</span>{{ $project->allocate }}</span>
                                </div>
                            </div>
                            <!--end: Item-->
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                <span class="mr-4">
                                    <i class="flaticon-chat-1 icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="d-flex flex-column">
                                    <span class="text-dark-75 font-weight-bolder font-size-sm">0 Pipelines</span>
                                    <a href="#" class="text-primary font-weight-bolder">View</a>
                                </div>
                            </div>
                            <!--end: Item-->
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
                                <span class="mr-4">
                                    <i class="flaticon-file-2 icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="d-flex flex-column flex-lg-fill">
                                    <span class="text-dark-75 font-weight-bolder font-size-sm">0 Tasks</span>
                                    <a href="#" class="text-primary font-weight-bolder">View</a>
                                </div>
                            </div>
                            <!--end: Item-->
                            <!--begin: Item-->
                            <div class="d-flex align-items-center flex-lg-fill my-1">
                                <span class="mr-4">
                                    <i class="flaticon-network icon-2x text-muted font-weight-bold"></i>
                                </span>
                                <div class="symbol-group symbol-hover">
                                    <div class="symbol symbol-30 symbol-circle" data-toggle="tooltip" title="{{ $project->assignedStaff->full_name }}">
                                        <img alt="{{ $project->assignedStaff->full_name }}" src="{{ $project->assignedStaff->user->image() }}" />

                                    </div>
                                </div>
                            </div>
                            <!--end: Item-->
                        </div>
                        <!--begin: Items-->
                    </div>
                </div>
                <!--end::Card-->

                <!--begin::Card-->
                <div class="card card-custom">
                    <!--begin::Header-->
                    <div class="card-header card-header-tabs-line">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-tabs-bold nav-tabs-line-3x" role="tablist">
                                <li class="nav-item mr-3">
                                    <a class="nav-link active" data-toggle="tab" href="#attachments_section">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text font-weight-bold">Files</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#kt_apps_projects_view_tab_1">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000" />
                                                        <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text font-weight-bold">Notes</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="tab-content pt-5">
                            <!--begin::Tab Content-->
                            <div class="tab-pane active" id="attachments_section" role="tabpanel">
                                <app-attachments type="project" id="{{ $project->id }}"></app-attachments>
                            </div>
                            <!--end::Tab Content-->
                            <!--begin::Tab Content-->
                            <div class="tab-pane" id="kt_apps_projects_view_tab_1" role="tabpanel">
                                <form class="form">
                                    <div class="form-group">
                                        <textarea class="form-control form-control-lg form-control-solid" id="exampleTextarea" rows="3" placeholder="Type notes"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <button class="btn btn-light-primary font-weight-bold" disabled>Add notes</button>
                                            <a href="#" class="btn btn-clean font-weight-bold">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!--end::Tab Content-->
                        </div>
                    </div>
                    <!--end::Body-->
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
