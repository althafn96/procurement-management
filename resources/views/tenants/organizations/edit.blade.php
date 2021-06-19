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
                        <h2 class="text-white font-weight-bold my-2 mr-5">Customer Organizations</h2>
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
                            <a href="{{ route('customer-organizations.index', [tenant()->id]) }}" class="text-white text-hover-white opacity-75 hover-opacity-100">Organizations</a>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Create Organization</a>
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
                            <a href="{{ route('customer-organizations.index', [tenant()->id]) }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn">
                                <i class="ki ki-long-arrow-back icon-sm"></i>
                                Back
                            </a>
                            <button form="kt_organization_update_form" id="kt_organization_update_btn" type="submit"
                                class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Update Organization
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('customer-organizations.update', ['tenant' => tenant()->id, 'customer_organization' => $organization]) }}" class="form" id="kt_organization_update_form">
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">Organization Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Name</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->name }}" class="form-control form-control-solid" type="text" name="name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Email</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->email }}" class="form-control form-control-solid" type="email" name="email" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Telephone</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->phone }}" class="form-control form-control-solid" type="text" name="phone" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Fax</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->fax }}" class="form-control form-control-solid" type="text" name="fax" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Mobile</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->mobile }}" class="form-control form-control-solid" type="text" name="mobile" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Address (Flat No.)</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->address_flat_no }}" class="form-control form-control-solid" type="text" name="address_flat_no" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Address (Street)</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->address_street }}" class="form-control form-control-solid" type="text" name="address_street" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">City</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->address_city }}" class="form-control form-control-solid" type="text" name="address_city" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">State</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->address_state }}" class="form-control form-control-solid" type="text" name="address_state" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Country</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->address_country }}" class="form-control form-control-solid" type="text" name="address_country" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">ZIP Code</label>
                                            <div class="col-9">
                                                <input value="{{ $organization->address_zip }}" class="form-control form-control-solid" type="text" name="address_zip" />
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
        <script src="{{ global_asset('assets/tenants/js/organizations.js') }}"></script>
    </x-slot>

</x-app-layout>
