<x-app-layout :title="$title">

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Edit Staff</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('staff.index') }}" class="text-muted">Staff</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">Edit Staff</span>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ route('staff.index') }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn"><i class="ki ki-long-arrow-back icon-sm"></i>Back</a>
                    <button form="kt_staff_update_form" id="kt_staff_update_btn" type="submit" class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Update Staff</button>
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
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('staff.update', [$user]) }}" class="form" id="kt_staff_update_form">
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">User Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">User Role</label>
                                            <div class="col-9">
                                                <select disabled name="role_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($roles as $role)
                                                        <option {{ $user->role_id == $role->id ? 'selected' : '' }} value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-left">Image</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <div class="image-input image-input-outline" id="kt_staff_add_avatar">
                                                    <div class="image-input-wrapper" style="background-image: url({{ $user->image() }})"></div>
                                                    <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="profile_avatar" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="profile_avatar_remove" />
                                                    </label>
                                                    <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">First Name</label>
                                            <div class="col-9">
                                                <input value="{{ $user->details->first_name }}" class="form-control form-control-solid" type="text" name="first_name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Last Name</label>
                                            <div class="col-9">
                                                <input value="{{ $user->details->last_name }}" class="form-control form-control-solid" type="text" name="last_name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-10"></div>
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">Login Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Email</label>
                                            <div class="col-9">
                                                <input value="{{ $user->email }}" class="form-control form-control-solid" type="email" name="email" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Change Password</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="password" name="password" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="permissions-section separator separator-dashed my-10"></div>
                                    <div id="permissions_list" class="permissions-section my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">Permissions:</h3>
                                        @foreach ($modules as $module)
                                        <div class="form-group row">
                                            <label class="col-3 col-form-label">{{ ucfirst($module->name) }}</label>
                                            <div class="col-9 col-form-label">
                                                <div class="checkbox-list">
                                                @foreach ($permissions as $permission)
                                                    @if ($permission->module_id == $module->id)
                                                        <label class="checkbox">
                                                            <input {{ $user->hasPermissionTo($permission->name) ? 'checked' : '' }} type="checkbox" value="{{ $permission->name }}" name="permissions[]"><span></span>{{ $permission->name }}
                                                        </label>
                                                    @endif
                                                @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-xl-2"></div>
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
        <script src="{{ asset('assets/master/js/staff.js') }}"></script>
    </x-slot>

</x-app-layout>
