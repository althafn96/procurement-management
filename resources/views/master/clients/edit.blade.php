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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Edit Client</h5>
                        <!--end::Page Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('clients.index') }}" class="text-muted">Clients</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">Edit Client</span>
                            </li>
                        </ul>
                        <!--end::Breadcrumb-->
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ route('clients.index') }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn"><i class="ki ki-long-arrow-back icon-sm"></i>Back</a>
                    <button form="kt_client_update_form" id="kt_client_update_btn" type="submit" class="btn btn-sm btn-primary font-weight-bolder"><i class="ki ki-check icon-sm"></i>Update Client</button>
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
                        <form method="POST" action="{{ route('clients.update', [$client]) }}" class="form" id="kt_client_update_form">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-xl-2"></div>
                                <div class="col-xl-8">
                                    <div class="my-5">
                                        <h3 class="text-dark font-weight-bold mb-10">General Info:</h3>
                                        <div class="form-group row">
                                            <label class="col-3">Company</label>
                                            <div class="col-9">
                                                <input value="{{ $client->company }}" class="form-control form-control-solid" type="text" name="company" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Plan</label>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    @foreach ($plans as $plan)
                                                        <div class="col-lg-4">
                                                            <label class="option">
                                                                <span class="option-control">
                                                                    <span class="radio radio-bold radio-brand">
                                                                        <input {{ $client->plan_id == $plan->id ? 'checked' : '' }}  type="radio" name="plan_id" value="{{ $plan->id }}">
                                                                        <span></span>
                                                                    </span>
                                                                </span>
                                                                <span class="option-label">
                                                                    <span class="option-head">
                                                                        <span class="option-title">{{ $plan->name }}</span>
                                                                    </span>
                                                                    <span class="option-body">{{ $plan->admins_count }} admin user account</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Email</label>
                                            <div class="col-9">
                                                <input value="{{ $client->email }}" class="form-control form-control-solid" type="text" name="email" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Phone</label>
                                            <div class="col-9">
                                                <input value="{{ $client->phone }}" class="form-control form-control-solid" type="text" name="phone" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Application URL path</label>
                                            <div class="col-9">
                                                <div class="input-group">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">{{ config('app.url') }}</span>
                                                    </div>
                                                    <input value="{{ $client->id }}" class="form-control form-control-solid" type="text" name="id" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Address 1</label>
                                            <div class="col-9">
                                                <input value="{{ $client->address_flat_no }}" class="form-control form-control-solid" type="text" name="address_flat_no" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Address 2</label>
                                            <div class="col-9">
                                                <input value="{{ $client->address_street }}" class="form-control form-control-solid" type="text" name="address_street" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Town</label>
                                            <div class="col-9">
                                                <input value="{{ $client->address_city }}" class="form-control form-control-solid" type="text" name="address_city" />
                                            </div>
                                        </div>
                                        {{-- <div class="form-group row">
                                            <label class="col-3">State</label>
                                            <div class="col-9">
                                                <input value="{{ $client->address_state }}" class="form-control form-control-solid" type="text" name="address_state" />
                                            </div>
                                        </div> --}}
                                        <div class="form-group row">
                                            <label class="col-3">Country</label>
                                            <div class="col-9">
                                                <input value="{{ $client->address_country }}" class="form-control form-control-solid" type="text" name="address_country" />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-3">Postcode</label>
                                            <div class="col-9">
                                                <input value="{{ $client->address_zip }}" class="form-control form-control-solid" type="text" name="address_zip" />
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
        <script src="{{ asset('assets/master/js/clients.js') }}"></script>
    </x-slot>
</x-app-layout>
