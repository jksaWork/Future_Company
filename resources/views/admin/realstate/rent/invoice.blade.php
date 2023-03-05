{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
        }

    </style>
@endsection
@section('title')
{{ __('translation.Print_outgoing_invoice') }}
@stop
@section('main-head', __('translation.spending'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card" id="print">
                <!--begin::Body-->
                <div class="card-body p-lg-20">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-xl-row">
                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid me-xl-18 mb-10 mb-xl-0">
                            <!--begin::Invoice 2 content-->
                            <div class="mt-n1">
                                <!--begin::Top-->
                                <div class="d-flex flex-stack pb-10">
                                    <!--begin::Logo-->
                                    <div class="col-md-6 d-flex">
                                        <a href="#">
                                            <img alt="Logo" src="{{ asset('uploads/' . setting('logo'))}}" class=" image-input-wrapper w-125px h-125px">
                                        </a>

                                        <div class="mx-5">

                                            <div class="col-sm-12">
                                                <!--end::Text-->
                                                <div class="fw-bolder fs-2 text-gray-800">{{ setting('title') }}</div>
                                            </div>

                                            <div class="row g-5 mb-1">
                                                <div class="col-sm-12">
                                                    <div class="fw-bold fs-7 text-gray-600 mt-2">{{ __('translation.invoice_number') }}:</div>
                                                    <div class="fw-bolder fs-6 text-gray-800"> # {{ $data->id }}</div>
                                                </div>
                                            </div>
                                            <div class="row g-5 ">
                                                <!--end::Col-->
                                                <div class="col-sm-12">
                                                    <!--end::Label-->
                                                    <div class="fw-bold fs-7 text-gray-600 ">{{ __('translation.Issue_Date') }}:</div>
                                                    <!--end::Label-->
                                                    <!--end::Col-->
                                                    <div class="fw-bolder fs-6 text-gray-800">{{ date('y-M-d h:i:s') }}</div>
                                                    <!--end::Col-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-end">

                                        <div class="mx-5">

                                            <div class="col-sm-12">
                                                <!--end::Text-->
                                                <div class="fw-bolder fs-2 text-gray-800">{{ __('translation.client_information_date') }}</div>
                                            </div>

                                            <div class="row g-5 mb-1">
                                                <div class="col-sm-12">
                                                    <div class="fw-bold fs-6 text-gray-600 mt-2"><span class="fw-bolder fs-4">
                                                        {{ __('translation.client_name') }}</span> : <span class='mx-2'> {{ $owner->name }}</span> </div>
                                                    {{-- <div class="fw-bolder fs-6 text-gray-800">{{ $data->id }}</div> --}}
                                                </div>
                                            </div>

                                            <div class="row g-5 mb-1">
                                                <div class="col-sm-12">
                                                    <div class="fw-bold fs-6 text-gray-600 mt-2"><span class="fw-bolder fs-4">
                                                        {{ __('translation.client_phone') }}</span> : <span class='mx-2'> {{ $owner->phone }}</span> </div>
                                                    {{-- <div class="fw-bolder fs-6 text-gray-800">{{ $data->id }}</div> --}}
                                                </div>
                                            </div>

                                            <div class="row g-5 mb-1">
                                                <div class="col-sm-12">
                                                    <div class="fw-bold fs-6 text-gray-600 mt-2"><span class="fw-bolder fs-4">
                                                        {{ __('translation.client_email') }}</span> : <span class='mx-2'> {{ $owner->email }}</span> </div>
                                                    {{-- <div class="fw-bolder fs-6 text-gray-800">{{ $data->id }}</div> --}}
                                                </div>
                                            </div>

                                            <div class="row g-5 mb-1">
                                                <div class="col-sm-12">
                                                    <div class="fw-bold fs-6 text-gray-600 mt-2"><span class="fw-bolder fs-4">
                                                        {{ __('translation.optration_type') }}</span> : <span class='mx-2'> {{ true ? __('translation.rent_renvue') : __('translation.sale_installment') }}</span> </div>
                                                    {{-- <div class="fw-bolder fs-6 text-gray-800">{{ $data->id }}</div> --}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                                <!--end::Top-->
                                <!--begin::Wrapper-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <div class="fw-bolder fs-3 text-gray-800 mb-8">{{ __('translation.Invoice') }} #{{ $data->id }}</div>
                                    <!--end::Row-->
                                    <div class="flex-grow-1">
                                        <!--begin::Table-->
                                        <div class="table-responsive border-bottom mb-9">
                                            <table class="table mb-3">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bolder text-muted">
                                                        <th class="min-w-175px pb-2">{{ __('translation.description') }}</th>
                                                        {{-- <th class="min-w-70px text-end pb-2">{{ __('translation.section_id') }}</th> --}}
                                                        <th class="min-w-100px text-end pb-2">{{ __('translation.the_amount') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="fw-bolder text-gray-700 fs-5 text-end">
                                                        <td class="d-flex align-items-center pt-6">{{ __('translation.recept_rent_renvue')  }} {{
                                                            __('translation.' . date("M", mktime(1, null, null, $data->month_number, 1)))
                                                            }}</td>
                                                        {{-- <i class="fa fa-genderless text-danger fs-2 me-2"></i>{{ $data->price }}</td> --}}
                                                        {{-- <td class="pt-6">{{ $data->price }}</td> --}}
                                                        <td class="pt-6 text-dark fw-boldest">{{ number_format($data->price,2) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                        <!--begin::Container-->
                                        <div class="d-flex justify-content-end">
                                            <!--begin::Section-->
                                            <div class="mw-300px">
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Accountname-->
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">{{ __('translation.total') }}:</div>
                                                    <!--end::Accountname-->
                                                    <!--begin::Label-->
                                                    <div class="text-end fw-bolder fs-6 text-gray-800">{{ number_format($data->price,2) }}</div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->

                                                <!--end::Item-->
                                            </div>
                                            <!--end::Section-->
                                        </div>
                                        <!--end::Container-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Wrapper-->
                            </div>

                            <!--end::Invoice 2 content-->
                        </div>
                        @php
                            $realState = $realstate;
                        @endphp
                        <div class="mt-5">
                            <div class="fw-bolder fs-3 text-gray-800 mb-8">{{ __('translation.realstate_info') }} #{{ $realState->id }}</div>

                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle gs-0 gy-3">
                                    <!--begin::Table head-->
                                    <thead>
                                        <tr class="fw-bolder text-muted bg-light">
                                            <th scope="row">
                                                <b>{{ __('translation.title') }}</b>
                                            </th>
                                            <td>{{ $realState->title }}</td>
                                            <th scope="row">{{ __('translation.realstate_number') }}</th>
                                            <td>{{ $realState->realstate_number }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">{{ __('translation.address') }}</th>
                                            <td>{{ $realState->address }}</td>
                                            <th scope="row">{{ __('translation.price') }}</th>
                                            <td>{{ $realState->price }}</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                        <div class="mt-3">
                            <a href="#" class="btn  btn-success mx-5" id="print_Button" onclick="printDiv()">{{ __('translation.print') }}</a>
                            <a href="{{ route('realstate.recept_revenues.hitory') }}" class="btn  btn-light-danger "  onclick="">{{ __('translation.ok') }}</a>
                        </div>
                    </div>

                    <!--end::Layout-->
                </div>
                <!--end::Body-->
            <div></div></div>
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

</script>
@endpush
