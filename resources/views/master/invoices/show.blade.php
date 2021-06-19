<x-app-layout :title="$title">

    <x-slot name="body_styles">
        print-content-only
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
                        <h5 class="text-dark font-weight-bold my-1 mr-5">INV {{ $invoice->invoice_no }}</h5>

                        <ul class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                            <li class="breadcrumb-item">
                                <a href="{{ route('invoices.index') }}" class="text-muted">Invoices</a>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">{{ $invoice->tenant->company }}</span>
                            </li>
                            <li class="breadcrumb-item">
                                <span class="text-muted">INV {{ $invoice->invoice_no }}</span>
                            </li>
                        </ul>
                    </div>
                    <!--end::Page Heading-->
                </div>
                <!--end::Info-->
                <!--begin::Toolbar-->
                <div class="d-flex align-items-center">
                    <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-light-primary font-weight-bolder mr-2 back-btn"><i class="ki ki-long-arrow-back icon-sm"></i>Back to Invoices</a>
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <!--end::Subheader-->
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <!-- begin::Card-->
                <div class="card card-custom overflow-hidden">
                    <div class="card-body p-0">
                        <!-- begin: Invoice-->
                        <!-- begin: Invoice header-->
                        <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
                                    <h1 class="display-4 font-weight-boldest mb-10">INVOICE</h1>
                                    <div class="d-flex flex-column align-items-md-end px-0">
                                        <!--begin::Logo-->
                                        <a href="#" onclick="return false" class="mb-5">
                                            {{-- <img src="{{ asset('assets/media/logos/logo-dark.png') }}" alt="" /> --}}
                                            <h6 style="margin-bottom: 0 !important; font-weight: bold; color: #000; text-transform: uppercase">{{ config('app.name') }}</h6>
                                        </a>
                                        <!--end::Logo-->
                                        <span class="d-flex flex-column align-items-md-end opacity-70">
                                            <span>Company Address, State, City</span>
                                            <span>Country 00000</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="border-bottom w-100"></div>
                                <div class="d-flex justify-content-between pt-6">
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">DATE</span>
                                        <span class="opacity-70">{{ $invoice->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">INVOICE NO.</span>
                                        <span class="opacity-70">INV {{ $invoice->invoice_no }}</span>
                                    </div>
                                    <div class="d-flex flex-column flex-root">
                                        <span class="font-weight-bolder mb-2">INVOICE TO.</span>
                                        <span class="opacity-70">{{ $invoice->tenant->company }}, {{ $invoice->tenant->address_flat_no }},
                                            <br />{{ $invoice->tenant->address_street == '' ? '' : $invoice->tenant->address_street . ', ' }} {{ $invoice->tenant->address_city }}, {{ $invoice->tenant->address_state }},
                                            <br />{{ $invoice->tenant->address_country }} {{ $invoice->tenant->address_zip }}.
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice header-->
                        <!-- begin: Invoice body-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="pl-0 font-weight-bold text-muted text-uppercase">Plan</th>
                                                <th class="text-right font-weight-bold text-muted text-uppercase">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $sum = 0;  @endphp
                                            @foreach ($invoice->items as $item)
                                                @php $sum += $item->price  @endphp
                                                <tr class="font-weight-boldest">
                                                    <td class="pl-0 pt-7">{{ $item->plan->name }}</td>
                                                    <td class="text-danger pr-0 pt-7 text-right">£{{ $item->price }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice body-->
                        <!-- begin: Invoice footer-->
                        <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th class="font-weight-bold text-muted text-uppercase"></th>
                                                <th class="font-weight-bold text-muted text-uppercase"></th>
                                                <th class="font-weight-bold text-muted text-uppercase"></th>
                                                <th class="font-weight-bold text-muted text-uppercase text-right">TOTAL AMOUNT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="font-weight-bolder">
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-danger font-size-h3 font-weight-boldest text-right">£{{ $sum }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice footer-->
                        <!-- begin: Invoice action-->
                        <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0">
                            <div class="col-md-9">
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-primary font-weight-bold" onclick="window.print();">Print Invoice</button>
                                </div>
                            </div>
                        </div>
                        <!-- end: Invoice action-->
                        <!-- end: Invoice-->
                    </div>
                </div>
                <!-- end::Card-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>

</x-app-layout>
