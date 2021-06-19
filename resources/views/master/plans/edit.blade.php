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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Edit Plan</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('plans.index') }}" class="text-muted">Plans</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">Edit Plan</span>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ route('plans.index') }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn"><i class="ki ki-long-arrow-back icon-sm"></i>Back</a>
                    <button form="kt_plan_update_form" id="kt_plan_update_btn" type="submit" class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Update Plan</button>
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
                        <form method="POST" action="{{ route('plans.update', [$plan->id]) }}" class="form" id="kt_plan_update_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">Plan Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Name</label>
                                            <div class="col-9">
                                                <input value="{{ $plan->name }}" class="form-control form-control-solid" type="text" name="name" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Price ({{ config('app.currency') }})</label>
                                            <div class="col-9">
                                                <input value="{{ $plan->price }}" class="form-control form-control-solid" type="number" min="0" name="price" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Admin User Count</label>
                                            <div class="col-9">
                                                <input value="{{ $plan->admins_count }}" class="form-control form-control-solid" type="number" name="admins_count" />
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
        <script src="{{ asset('assets/master/js/plans.js') }}"></script>
    </x-slot>
</x-app-layout>
