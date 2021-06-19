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
                        <h2 class="text-white font-weight-bold my-2 mr-5">Staff</h2>
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
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Staff</a>
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
                                <i class="flaticon-users-1 text-primary"></i> &nbsp;
                            </span>
                            <h3 class="card-label">All Staff
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            @if (tenant()->admins->count() < tenant()->plan->admins_count)
                                <a href="{{ route('client-staff.create', [tenant()->id]) }}" class="btn btn-primary font-weight-bold btn-sm create-btn"><i class="ki ki-plus icon-sm"></i>Create Staff</a>
                            @endif
                            <!--end::Button-->
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table
                        data-url="{{ route('client-staff.index', [tenant()->id]) }}"
                        data-edit="{{ auth()->user()->can('edit staff') }}"
                        data-remove="{{ auth()->user()->can('remove staff') }}"
                        data-id="{{ auth()->id() }}"
                        data-role="{{ auth()->user()->role->name }}"
                        class="table table-separate table-head-custom collapsed"
                        id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Staff</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Staff</th>
                                    <th>Role</th>
                                    <th>Status</th>
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

    <x-slot name="scripts">
        <script src="{{ global_asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ global_asset('assets/tenants/js/staff.js') }}"></script>
    </x-slot>
</x-app-layout>
