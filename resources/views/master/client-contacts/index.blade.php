<x-app-layout :title="$title">

    <x-slot name="styles">
        <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <!--begin::Subheader-->
        <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
            <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                <!--begin::Info-->
                <div class="d-flex align-items-center flex-wrap mr-1">
                    <!--begin::Page Heading-->
                    <div class="d-flex align-items-baseline flex-wrap mr-5">
                        <!--begin::Page Title-->
                        <h5 class="text-dark font-weight-bold my-1 mr-5">Contacts of {{ $client->company }}</h5>

                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('clients.index') }}" class="text-muted">Clients</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">{{ $client->company }}</span>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">Contacts</span>
                            </li>
                        </ul>
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ route('clients.index') }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn"><i class="ki ki-long-arrow-back icon-sm"></i>Clients</a>

                    @can('create contact')
                        <!--begin::Actions-->
                        <a href="{{ route('contacts.create', [$client]) }}" class="btn btn-primary font-weight-bold btn-sm create-btn"><i class="ki ki-plus icon-sm"></i>Create Contact</a>
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
                <div class="card card-custom gutter-b">
                    <!--begin::Header-->
                    <div class="card-header card-header-tabs-line">
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-tabs-space-lg nav-tabs-line nav-bold nav-tabs-line-3x" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#kt_apps_contacts_view_tab_1">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/General/Notification2.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M13.2070325,4 C13.0721672,4.47683179 13,4.97998812 13,5.5 C13,8.53756612 15.4624339,11 18.5,11 C19.0200119,11 19.5231682,10.9278328 20,10.7929675 L20,17 C20,18.6568542 18.6568542,20 17,20 L7,20 C5.34314575,20 4,18.6568542 4,17 L4,7 C4,5.34314575 5.34314575,4 7,4 L13.2070325,4 Z" fill="#000000"></path>
                                                        <circle fill="#000000" opacity="0.3" cx="18.5" cy="5.5" r="2.5"></circle>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text">All Contacts</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link" data-toggle="tab" href="#kt_apps_contacts_view_tab_2">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                        <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text">Contact Admin Login</span>
                                    </a>
                                </li>
                                <li class="nav-item mr-3">
                                    <a class="nav-link" data-toggle="tab" href="#kt_apps_client_guest_login">
                                        <span class="nav-icon mr-2">
                                            <span class="svg-icon mr-3">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Chat-check.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24"></rect>
                                                        <path d="M4.875,20.75 C4.63541667,20.75 4.39583333,20.6541667 4.20416667,20.4625 L2.2875,18.5458333 C1.90416667,18.1625 1.90416667,17.5875 2.2875,17.2041667 C2.67083333,16.8208333 3.29375,16.8208333 3.62916667,17.2041667 L4.875,18.45 L8.0375,15.2875 C8.42083333,14.9041667 8.99583333,14.9041667 9.37916667,15.2875 C9.7625,15.6708333 9.7625,16.2458333 9.37916667,16.6291667 L5.54583333,20.4625 C5.35416667,20.6541667 5.11458333,20.75 4.875,20.75 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                        <path d="M2,11.8650466 L2,6 C2,4.34314575 3.34314575,3 5,3 L19,3 C20.6568542,3 22,4.34314575 22,6 L22,15 C22,15.0032706 21.9999948,15.0065399 21.9999843,15.009808 L22.0249378,15 L22.0249378,19.5857864 C22.0249378,20.1380712 21.5772226,20.5857864 21.0249378,20.5857864 C20.7597213,20.5857864 20.5053674,20.4804296 20.317831,20.2928932 L18.0249378,18 L12.9835977,18 C12.7263047,14.0909841 9.47412135,11 5.5,11 C4.23590829,11 3.04485894,11.3127315 2,11.8650466 Z M6,7 C5.44771525,7 5,7.44771525 5,8 C5,8.55228475 5.44771525,9 6,9 L15,9 C15.5522847,9 16,8.55228475 16,8 C16,7.44771525 15.5522847,7 15,7 L6,7 Z" fill="#000000"></path>
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                        </span>
                                        <span class="nav-text">Client Guest Login</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body px-0">
                        <div class="tab-content pt-5">
                            <!--begin::Tab Content-->
                            <div class="tab-pane active" id="kt_apps_contacts_view_tab_1" role="tabpanel">
                                <div class="container"><!--begin: Datatable-->
                                    <table data-url="{{ route('contacts.index', [$client]) }}"
                                            data-edit="{{ auth()->user()->can('edit contact') }}"
                                            data-remove="{{ auth()->user()->can('remove contact') }}"
                                            class="table table-separate table-head-custom collapsed"
                                            id="kt_datatable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Contact</th>
                                                <th>Client</th>
                                                <th>Designation</th>
                                                <th>Phone</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>Contact</th>
                                                <th>Client</th>
                                                <th>Designation</th>
                                                <th>Phone</th>
                                                <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <!--end: Datatable-->
                                </div>
                            </div>
                            <!--end::Tab Content-->
                            <!--begin::Tab Content-->
                            <div class="tab-pane" id="kt_apps_contacts_view_tab_2" role="tabpanel">

                                <div class="row">
                                    <div id="alert_client_admin" class="col-md-12">
                                        @if ($client_admin)
                                        <div class="alert alert-success p-5 mx-5" role="alert">
                                            <p>Client Admin for {{ $client->company }} has been set set to {{ $client_admin->full_name }} ({{ $client_admin->email }}). You can update the password of {{ $client_admin->email }}, or change the Client Admin here.</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <form method="POST" action="{{ url('add-client-admin-from-contact/' . $client->id) }}" id="update_client_admin_form" class="form">
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-right">Client Admin Email</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <select name="contact_admin" class="form-control form-control-solid kt-selectpicker">
                                                <option value="">--SELECT CONTACT--</option>
                                                @foreach ($contacts as $contact)
                                                    <option {{ $client_admin->contact_id ?? '' == $contact->id ? 'selected' : '' }} value="{{ $contact->id }}">{{ $contact->full_name }} ({{ $contact->email }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-right">
                                            @if ($client_admin)
                                            Change Client Admin Password
                                            @else
                                            Client Admin Password
                                            @endif
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input name="admin_password" class="form-control form-control-solid" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xl-9 col-lg-9 col-form-label text-right">
                                            <button  id="update_client_admin_btn" type="submit" class="btn btn-primary font-weight-bold mr-2">
                                                @if ($client_admin)
                                                Update Login
                                                @else
                                                Add Login
                                                @endif

                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <!--end::Tab Content-->
                            <!--begin::Tab Content-->
                            <div class="tab-pane" id="kt_apps_client_guest_login" role="tabpanel">

                                <form method="POST" action="{{ url('add-or-update-client-guest-from-contact/' . $client->id) }}" id="update_client_guest_form" class="form">

                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-right">Client Guest Email</label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input value="{{ $client_guest->email ?? '' }}" name="guest_email" class="form-control form-control-solid" type="email">
                                            <input type="hidden" name="customer_id" id="guest_customer_id" value="{{ $client_guest->id ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-xl-3 col-lg-3 col-form-label text-right">
                                            @if ($client_guest)
                                            Change Client Guest Password
                                            @else
                                            Client Guest Password
                                            @endif
                                        </label>
                                        <div class="col-lg-9 col-xl-6">
                                            <input name="guest_password" class="form-control form-control-solid" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-xl-9 col-lg-9 col-form-label text-right">
                                            <button  id="update_client_guest_btn" type="submit" class="btn btn-primary font-weight-bold mr-2">
                                                @if ($client_guest)
                                                Update Login
                                                @else
                                                Add Login
                                                @endif

                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                            <!--end::Tab Content-->
                        </div>
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

    <x-slot name="scripts">
        <script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script src="{{ asset('assets/master/js/client-contacts.js') }}"></script>
    </x-slot>
</x-app-layout>
