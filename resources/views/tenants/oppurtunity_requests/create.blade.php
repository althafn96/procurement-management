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
                            <a href="{{ route('opportunity-requests.index', [tenant()->id]) }}" class="text-white text-hover-white opacity-75 hover-opacity-100">Opportunity Requests</a>
                            <!--end::Item-->
                            <!--begin::Item-->
                            <span class="label label-dot label-sm bg-white opacity-75 mx-3"></span>
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Create Opportunity Request</a>
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
                            <a href="{{ route('opportunity-requests.index', [tenant()->id]) }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn">
                                <i class="ki ki-long-arrow-back icon-sm"></i>
                                Back
                            </a>
                            <button form="kt_opportunity_request_add_form" id="kt_opportunity_request_add_btn" type="submit"
                                class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Save Request
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('opportunity-requests.store', [tenant()->id]) }}" class="form" id="kt_opportunity_request_add_form">
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">New Request:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Title</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="text" name="title" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
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
                                        <div class="form-group row">
                                            <label class="col-3">Stakeholder</label>
                                            <div class="col-9">
                                                <select name="client_customer_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Supplier</label>
                                            <div class="col-9">
                                                <select id="supplier_id" name="supplier_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                                    @endforeach
                                                    <option value="addnewsupplier">➕ Add New Supplier</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Estimated Budget</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="number" name="estimated_budget" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Current Value</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="number" name="current_value" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Savings</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid" type="number" name="savings" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Description</label>
                                            <div class="col-9">
                                                <textarea class="form-control form-control-solid" name="description" id="" cols="15" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Contract Start Date</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid kt-datepicker" type="text" readonly="readonly" name="contract_start_date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Contract End Date</label>
                                            <div class="col-9">
                                                <input class="form-control form-control-solid kt-datepicker" type="text" readonly="readonly" name="contract_end_date" />
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

    <div class="modal fade" id="supplierAddModal" tabindex="-1" role="dialog" aria-labelledby="supplierAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content model-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="supplierAddModalLabel">Add New Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('suppliers.store', [tenant()->id]) }}" class="form" id="kt_supplier_add_form">
                        <div class="row">
                            <div class="col-xl-2"></div>
                            <div class="col-xl-8">
                                <div class="my-5">
                                    <h3 class="text-dark font-weight-bold mb-10">Supplier Info:</h3>
                                    <div class="form-group row">
                                        <input class="form-control form-control-solid" type="hidden" name="add_from" value="oppurtunity_request" />
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-left">Image</label>
                                        <div class="col-lg-9 col-xl-9">
                                            <div class="image-input image-input-outline" id="kt_supplier_add_avatar">
                                                <div class="image-input-wrapper" style="background-image: url({{ global_asset('assets/media/users/blank.png') }})"></div>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="submit"  form="kt_supplier_add_form" id="kt_supplier_add_btn" class="btn btn-primary font-weight-bold">Save Supplier</button>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script src="{{ global_asset('assets/tenants/js/opportunity_requests.js') }}"></script>
        <script src="{{ global_asset('assets/tenants/js/suppliers.js') }}"></script>
    </x-slot>

</x-app-layout>
