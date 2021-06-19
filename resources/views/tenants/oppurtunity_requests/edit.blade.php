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
                            <a href="#" onclick="return false;" class="text-white text-hover-white opacity-75 hover-opacity-100">Edit Opportunity Request</a>
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
                            <button form="kt_opportunity_request_update_form" id="kt_opportunity_request_update_btn" type="submit"
                                class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Update Request
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin::Form-->
                        <form method="POST" action="{{ route('opportunity-requests.update', ['tenant'=>tenant()->id, 'opportunity_request'=>$opportunity_request]) }}" class="form" id="kt_opportunity_request_update_form">
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">Request Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Title</label>
                                            <div class="col-9">
                                                <input value="{{ $opportunity_request->title }}" class="form-control form-control-solid" type="text" name="title" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Category</label>
                                            <div class="col-9">
                                                <select name="category_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($categories as $category)
                                                        <option {{ $opportunity_request->category_id == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }} ({{ $category->code }})</option>
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
                                                        <option {{ $opportunity_request->client_customer_id == $customer->id ? 'selected' : '' }} value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Supplier</label>
                                            <div class="col-9">
                                                <select name="supplier_id" class="form-control form-control-solid kt-selectpicker">
                                                    <option value=""></option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option {{ $opportunity_request->supplier_id == $supplier->id ? 'selected' : '' }} value="{{ $supplier->id }}">{{ $supplier->full_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Estimated Budget</label>
                                            <div class="col-9">
                                                <input value="{{ $opportunity_request->estimated_budget }}" class="form-control form-control-solid" type="number" name="estimated_budget" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Current Value</label>
                                            <div class="col-9">
                                                <input value="{{ $opportunity_request->current_value }}" class="form-control form-control-solid" type="number" name="current_value" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Savings</label>
                                            <div class="col-9">
                                                <input value="{{ $opportunity_request->savings }}" class="form-control form-control-solid" type="number" name="savings" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Description</label>
                                            <div class="col-9">
                                                <textarea class="form-control form-control-solid" name="description" id="" cols="15" rows="5">{{ $opportunity_request->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Contract Start Date</label>
                                            <div class="col-9">
                                                <input value="{{ $opportunity_request->contract_start_date }}" class="form-control form-control-solid kt-datepicker" type="text" readonly="readonly" name="contract_start_date" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Contract End Date</label>
                                            <div class="col-9">
                                                <input value="{{ $opportunity_request->contract_end_date }}"class="form-control form-control-solid kt-datepicker" type="text" readonly="readonly" name="contract_end_date" />
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
        <script src="{{ global_asset('assets/tenants/js/opportunity_requests.js') }}"></script>
    </x-slot>

</x-app-layout>
