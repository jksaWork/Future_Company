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
{{ __('translation.Print_salaries_invoice') }}
@stop
@section('main-head', __('translation.salaries'))
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
                                    <a href="#">
                                        <img alt="Logo" src="{{ asset('uploads/' . setting('logo'))}}" class="h-30px image-input-wrapper w-125px h-125px"> 
                                    </a>
                                    <!--end::Logo-->
                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-sm btn-success" id="print_Button" onclick="printDiv()">{{ __('translation.print') }}</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Wrapper-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <div class="fw-bolder fs-3 text-gray-800 mb-8">{{ __('translation.Invoice') }} #{{$salaries->id}}</div>
                                    <!--end::Label-->
                                    <!--begin::Row-->
                                    <div class="row g-5 mb-11">
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{ __('translation.Issue_Date') }}:</div>
                                            <!--end::Label-->
                                            <!--end::Col-->
                                            <div class="fw-bolder fs-6 text-gray-800">{{ $salaries->month_number}}/{{ $salaries->year}}{{ __('translation.monthes') }}</div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{ __('translation.Added_date') }}:</div>
                                            <!--end::Label-->
                                            <!--end::Info-->
                                            <div class="fw-bolder fs-6 text-gray-800 d-flex align-items-center flex-wrap">
                                                <span class="pe-2">{{ $salaries->created_at }}</span>
                                                <span class="fs-7 text-danger d-flex align-items-center">
                                                {{-- <span class="bullet bullet-dot bg-danger me-2"></span>Due in 7 days</span> --}}
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="row g-5 mb-12">
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{ __('translation.Issue_For') }}:</div>
                                            <!--end::Label-->
                                            <!--end::Text-->
                                            <div class="fw-bolder fs-6 text-gray-800">{{ $salaries->teachers->name  }}</div>
                                            <!--end::Text-->
                                            <!--end::Description-->
                                            {{-- <div class="fw-bold fs-7 text-gray-600">8692 Wild Rose Drive
                                            <br>Livonia, MI 48150</div> --}}
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{ __('translation.Issue_By') }}:</div>
                                            <!--end::Label-->
                                            <!--end::Text-->
                                            <div class="fw-bolder fs-6 text-gray-800">{{ $salaries->School->school_name  }}</div>
                                            <!--end::Text-->
                                            <!--end::Description-->
                                            {{-- <div class="fw-bold fs-7 text-gray-600">9858 South 53rd Ave.
                                            <br>Matthews, NC 28104</div> --}}
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Content-->
                                    <div class="flex-grow-1">
                                        <!--begin::Table-->
                                        <div class="table-responsive border-bottom mb-9">
                                            <table class="table mb-3">
                                                <thead>
                                                    <tr class="border-bottom fs-6 fw-bolder text-muted">
                                                        <th class="min-w-175px pb-2"></th>
                                                        <th class="min-w-100px text-end pb-2"></th>
                                                        <th class="min-w-70px text-end pb-2">{{ __('translation.description') }}</th>
                                                        <th class="min-w-80px text-end pb-2">{{ __('translation.Amount') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="fw-bolder text-gray-700 fs-5 text-end">
                                                        <td class="pt-6"></td>
                                                        <td class="d-flex align-items-center pt-6"></td>
                                                        <td class="pt-6">
                                                            <i class="fa fa-genderless text-danger fs-2 me-2"></i>{{ __('translation.fixed_salary') }}</td>
                                                        <td class="pt-6 text-dark fw-boldest">{{ number_format($salaries->fixed_salary,2)  }}</td>
                                                    </tr>
                                                    <tr class="fw-bolder text-gray-700 fs-5 text-end"></td>
                                                        <td></td>
                                                        <td class="d-flex align-items-center"></td>
                                                        <td>
                                                            <i class="fa fa-genderless text-success fs-2 me-2" style="
                                                            padding: 0px 19px 0px;
                                                        "></i>{{ __('translation.allowancess_fixed') }}</td>
                                                        <td class="fs-5 text-dark fw-boldest">{{ number_format($salaries->allowancess_fixed,2)  }}</td>
                                                    </tr>
                                                    <tr class="fw-bolder text-gray-700 fs-5 text-end"></td>
                                                        <td></td>
                                                        <td class="d-flex align-items-center"></td>
                                                        <td>
                                                            <i class="fa fa-genderless text-primary fs-2 me-2" style="
                                                            padding: 0px 29px 0px;"></i>{{ __('translation.advances') }}</td>
                                                        <td class="fs-5 text-dark fw-boldest"><span class='badge badge-danger'>{{ number_format($salaries->advances,2)}}</span></td>
                                                    </tr>
                                                    <tr class="fw-bolder text-gray-700 fs-5 text-end"></td>
                                                        <td></td>
                                                        <td class="d-flex align-items-center"></td>
                                                        
                                                        <td><i class="fa fa-genderless text-primary fs-2 me-2" style="
                                                            padding: 0px 41px 0px;"></i>{{ __('translation.discounts') }}</td>
                                                        <td class="fs-5 text-dark fw-boldest"><span class='badge badge-danger'>{{ number_format($salaries->discounts,2)}}</span></td>
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
                                                    <div class="fw-bold pe-10 text-gray-600 fs-7">{{ __('translation.totle_salaries') }}:</div>
                                                    <!--end::Accountname-->
                                                    <!--begin::Label-->
                                                    <div class="text-end fw-bolder fs-6 text-gray-800"><span class='badge badge-warning'>{{ $salaries->totle_salaries}}</span></div>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Accountname-->
                                                    {{-- <div class="fw-bold pe-10 text-gray-600 fs-7">VAT 0%</div> --}}
                                                    <!--end::Accountname-->
                                                    <!--begin::Label-->
                                                    {{-- <div class="text-end fw-bolder fs-6 text-gray-800">0.00</div> --}}
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack mb-3">
                                                    <!--begin::Accountnumber-->
                                                    {{-- <div class="fw-bold pe-10 text-gray-600 fs-7">Subtotal + VAT</div> --}}
                                                    <!--end::Accountnumber-->
                                                    <!--begin::Number-->
                                                    {{-- <div class="text-end fw-bolder fs-6 text-gray-800">{{ $salaries->totle_salaries}}</div> --}}
                                                    <!--end::Number-->
                                                </div>
                                                <!--end::Item-->
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Code-->
                                                    {{-- <div class="fw-bold pe-10 text-gray-600 fs-7">Total</div> --}}
                                                    <!--end::Code-->
                                                    <!--begin::Label-->
                                                    {{-- <div class="text-end fw-bolder fs-6 text-gray-800">$ 20,600.00</div> --}}
                                                    <!--end::Label-->
                                                </div>
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
                        <!--end::Content-->
                        <!--begin::Sidebar-->
                       
                        <!--end::Sidebar-->
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