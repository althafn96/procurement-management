<x-app-layout :title="$title">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <!--begin::Subheader-->
        @if(auth()->user()->role->type == 'master')
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Create User Role</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul
                            class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/user-roles') }}" class="text-muted">User Roles</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">Create User Role</span>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ url('/user-roles') }}"
                        class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn"><i
                            class="ki ki-long-arrow-back icon-sm"></i>Back</a>
                    <button form="kt_user_role_add_form" id="kt_user_role_add_btn" type="submit"
                        class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Save User
                        Role</button>
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        @else
        <div class="subheader py-2 py-lg-12 subheader-transparent" id="kt_subheader">
            <div class="container d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column">
                        <!--begin::Title-->
                        <h2 class="text-white font-weight-bold my-2 mr-5">Create User Role</h2>
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
                            <a href="{{ url(tenant()->id.'/user-roles') }}" class="text-white text-hover-white opacity-75 hover-opacity-100">User Roles</a>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Create User Role</a>
                            <!--end::Item-->
                        </div>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Heading-->
                </div>
                <!--end::Info-->
            </div>
        </div>
        @endif
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!--begin::Card-->
                <div class="card card-custom  {{ auth()->user()->role->type == 'client' ? 'card-sticky' : '' }}" id="{{ auth()->user()->role->type == 'client' ? 'kt_page_sticky_card' : '' }}">
                    @if (auth()->user()->role->type == 'client')
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">
                                    &nbsp;
                                </h3>
                            </div>
                            <div class="card-toolbar">
                                <a href="{{ url(tenant()->id . '/user-roles') }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn">
                                    <i class="ki ki-long-arrow-back icon-sm"></i>
                                    Back
                                </a>
                                <button form="kt_user_role_add_form" id="kt_user_role_add_btn" type="submit"
                                    class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Save User
                                    Role
                                </button>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <!--begin::Form-->
                        @if (auth()->user()->role->type == 'master')
                        <form method="POST" action="{{ url('user-roles') }}" class="form" id="kt_user_role_add_form">
                        @else
                        <form method="POST" action="{{ url(tenant()->id.'/user-roles') }}" class="form" id="kt_user_role_add_form">
                        @endif
                            @csrf
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">User Role Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Role Name</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text"
                                                    name="role" />
                                                <input class="form-control form-control-solid" type="hidden" name="type"
                                                    value="{{ auth()->user()->role->type }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-10"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">Permissions:</h3>
                                        @foreach ($modules as $module)
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">{{ ucfirst($module->name) }}</label>
                                            <div class="col-9 col-form-label">
                                                <div class="checkbox-list">
                                                    @foreach ($permissions as $permission)
                                                    @if ($permission->module_id == $module->id)
                                                    <label class="checkbox">
                                                        <input type="checkbox" value="{{ $permission->name }}"
                                                            name="permissions[]"><span></span>{{ $permission->name }}
                                                    </label>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

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
        <script src="{{ global_asset('assets/master/js/user-roles.js') }}"></script>
    </x-slot>
</x-app-layout>
