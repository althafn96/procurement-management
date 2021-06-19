<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-1">
                <!--begin::Page Heading-->
                <div class="d-flex align-items-baseline flex-wrap mr-5">
                    <!--begin::Page Title-->
                    <span class="card-icon">
                        <i class="flaticon2-lock text-primary"></i> &nbsp;
                    </span>
                    <h5 class="card-label">User Roles</h5>
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
            <!--begin::Toolbar-->
            <div class="d-flex align-items-center">
                @can('create user role')
                    <!--begin::Actions-->
                    <a href="{{ url('user-roles/create') }}" class="btn btn-primary font-weight-bold btn-sm create-btn"><i class="ki ki-plus icon-sm"></i>Create User Role</a>
                    <!--end::Actions-->
                @endcan
            </div>
            <!--end::Toolbar-->
        </div>
    </div>
    <!--end::Subheader-->
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                <div class="card-body">
                    <!--begin: Datatable-->
                    <table data-url="{{ url('/user-roles') }}"
                            data-edit="{{ auth()->user()->can('edit user role') }}"
                            data-remove="{{ auth()->user()->can('remove user role') }}"
                            data-id="{{ url('user-roles') }}"
                            class="table table-separate table-head-custom collapsed"
                            id="kt_datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
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
