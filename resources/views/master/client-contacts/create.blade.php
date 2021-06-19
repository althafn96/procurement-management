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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Add Contact</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('contacts.index', [$client]) }}" class="text-muted">Contacts</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">Add Contact</span>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ route('contacts.index', [$client]) }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn"><i class="ki ki-long-arrow-back icon-sm"></i>Back</a>
                    <button form="kt_contact_add_form" id="kt_contact_add_btn" type="submit" class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Save Contact</button>
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
                        <form method="POST" action="{{ route('contacts.store', $client) }}" class="form" id="kt_contact_add_form">
                            @csrf
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">General Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-xl-3 col-lg-3 col-form-label text-left">Image</label>
                                            <div class="col-lg-9 col-xl-9">
                                                <div class="image-input image-input-outline" id="kt_staff_add_avatar">
                                                    <div class="image-input-wrapper" style="background-image: url({{ asset('assets/media/users/blank.png') }})"></div>
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
                                            <label class="col-3">Client</label>
                                            <div class="col-9">
                                                <select disabled name="tenant_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value="{{ $client->id }}">{{ $client->company }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Title</label>
                                            <div class="col-9">
                                                <select name="title" class="form-control form-control-solid kt-selectpicker">
                                                    <option value="Mr. ">Mr</option>
                                                    <option value="Mrs. ">Mrs</option>
                                                    <option value="Miss. ">Miss</option>
                                                    <option value="Dr. ">Dr</option>
                                                    <option value="Master. ">Master</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">First Name</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="first_name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Last Name</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="last_name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Designation</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="position" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Email</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="email" name="email" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Telephone</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="phone" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Fax</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="fax" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Mobile</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="mobile" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Address (Flat No.)</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="address_flat_no" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Address (Street)</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="address_street" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">City</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="address_city" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">State</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="address_state" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Country</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="address_country" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">ZIP Code</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="address_zip" />
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
        <script src="{{ asset('assets/master/js/client-contacts.js') }}"></script>
    </x-slot>
</x-app-layout>
