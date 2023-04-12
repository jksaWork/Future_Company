@extends('layouts.school.master')
@section('main-head')
{{ __('translation.Outgoing_details') }}
<small>-- {{$type_accounts->spending_name}} --</small>
@endsection
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
            #form{
                display: none;
            }
            #end_colum{
                display: none;
            }
        }

    </style>
@endsection
@section('title')
{{$type_accounts->spending_name}}
   
@stop
{{-- @section('main-head', __('translation.spending_report') ) --}}
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card" id="print">
<<<<<<< HEAD
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    {{-- <div class="card-title"> --}}
                    <!--begin::Search-->
                    <div class="d-flex justify-conetnt-between align-items-center position-relative my-1 col-md-8">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
=======
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
                                        <img alt="Logo" src="{{ asset('school_uploads/'. setting('school_fav_icon')) }}" class=" image-input-wrapper w-125px h-125px"> 
                                    </a>
                                    <!--end::Logo-->
                                    <!--begin::Action-->
                                    <a href="#" class="btn btn-sm btn-success " id="print_Button" onclick="printDiv()">{{ __('translation.print') }}</a>
                                    <!--end::Action-->
                                </div>
                                <!--end::Top-->
                                <!--begin::Wrapper-->
                                <div class="m-0">
                                    <!--begin::Label-->
                                    <div class="fw-bolder fs-3 text-gray-800 mb-8">{{ __('translation.Invoice') }} #{{ $spending->id }}</div>
                                    <!--end::Label-->
                                    <!--begin::Row-->
                                    <div class="row g-5 mb-11">
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{ __('translation.Issue_Date') }}:</div>
                                            <!--end::Label-->
                                            <!--end::Col-->
                                            <div class="fw-bolder fs-6 text-gray-800">{{ $spending->month }}</div>
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
                                                <span class="pe-2">{{ $spending->created_at }}</span>
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
                                            <div class="fw-bolder fs-6 text-gray-800">{{ $spending->spending_name }}</div>
                                            <!--end::Text-->
                                            <!--end::Description-->
                                            <!--end::Description-->
                                        </div>
                                        <!--end::Col-->
                                        <!--end::Col-->
                                        <div class="col-sm-6">
                                            <!--end::Label-->
                                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{ __('translation.Issue_By') }}:</div>
                                            <!--end::Label-->
                                            <!--end::Text-->
                                            <div class="fw-bolder fs-6 text-gray-800">{{ setting('school_title') }}</div>
                                            <!--end::Text-->
                                            <!--end::Description-->
                                           
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
                                                        <th class="min-w-175px pb-2">{{ __('translation.school_type') }}</th>
                                                        <th class="min-w-70px text-end pb-2">{{ __('translation.section_id') }}</th>
                                                        <th class="min-w-70px text-end pb-2"></th>
                                                        <th class="min-w-100px text-end pb-2">{{ __('translation.the_amount') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="fw-bolder text-gray-700 fs-5 text-end">
                                                        <td class="d-flex align-items-center pt-6">
                                                        <i class="fa fa-genderless text-danger fs-2 me-2"></i>{{ $spending->school->school_name }}</td>
                                                        <td class="pt-6">{{ $spending->section->section_name }}</td>
                                                        <td class="pt-6"></td>
                                                        <td class="pt-6 text-dark fw-boldest">{{ number_format($spending->spending_value,2) }}</td>
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
                                                    <div class="text-end fw-bolder fs-6 text-gray-800">{{ number_format($spending->spending_value,2) }}</div>
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
                        <!--end::Content-->
                        <!--begin::Sidebar-->
>>>>>>> master
                       
                        {{-- </form> --}}


                    </div>

                   
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <div class="d-flex flex-stack pb-10">
                        <!--begin::Logo-->
                        <a href="#"> </a>
                        <!--end::Logo-->
                        <!--begin::Action-->
                        <a href="#" class="btn btn-sm btn-success" id="print_Button" onclick="printDiv()">{{ __('translation.print') }}</a>
                        <!--end::Action-->
                    </div>
                    <form action="{{ route('School.spending.print', $x) }}"  id='form'>
                        <div class="form-group row" >
                       
                            <div class="fv-row mb-7 col-md-12 ">
                                <input type="hidden" class="form-control form-control-solid"
                                    placeholder="" id="pro_id" value='{{$type_accounts->spending_name}}'/>
                            
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('translation.being_month') }}:</label>
                                <input type="date" name='being_month' class="form-control mb-2 mb-md-0" value="{{date('Y-M-D')}}"/>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">{{ __('translation.end_month') }}:</label>
                                <input type="date" name='end_month' value="{{ date('Y-m-d') }}" class="form-control mb-2 mb-md-0" placeholder="Enter contact number" />
                            </div>
                            
                            <div class="col-md-6" style="
                            text-align: -webkit-auto;
                            padding: 26px;
                        ">
                              <button  class="btn btn-primary"> {{ __('translation.search') }}
                                </button>
                            </div>

                    
                        </div>
                    </form><br><br><br>
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-rounded table-striped border gy-7 gs-7"
                                    id="example1" >
                                    <thead>
                                        <tr  class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200"   style="text-align: center;">
                                            <th class="">{{ __('translation.data') }}</th>
                                            <th class="">{{ __('translation.for_him') }}</th>
                                            <th class="">{{ __('translation.on_him') }}</th>
                                            <th class="">{{ __('translation.date') }}</th>
                                            <th id = "end_colum">@lang('translation.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                        <?php $sum_pluss = 0; ?>
                                        <?php $sum_mouns = 0; ?>
                                        @forelse ($pluss as $pluss)
                                        @if ($pluss->status == 1)
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200"   style="text-align: center;">
                                           <td>{{ $pluss->spendings->section->section_name}} - {{$pluss->description}}</td>
                                            <td style="
                                            color: #950101;
                                        ">0</td>
                                            <td style="
                                            color: #019501;
                                        ">{{ $pluss->value }}</td>
                                            <td>{{ $pluss->month}}</td> 
                                            <td id = "end_colum"><a href="{{ route('School.account.edit' , $pluss->id) }}" class="btn btn-light-info btn-sm btn-icon me-1">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                            </a></td>
                                            <?php $sum_pluss += $pluss->value; ?>
                                        </tr>
                                        @else
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200"  style="text-align: center;" >
                                            <td>{{ $pluss->spendings->section->section_name}} - {{$pluss->description}}</td>
                                            <td style="
                                            color: #950101;
                                        ">{{ $pluss->value }}</td>
                                            <td style="
                                            color: #019501;
                                        ">0</td>
                                            <td>{{ $pluss->month}}</td>
                                            <td id = "end_colum"><a href="{{ route('School.account.edit' , $pluss->id) }}" class="btn btn-light-info btn-sm btn-icon me-1">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black"></path>
                                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black"></path>
                                                    </svg>
                                                </span>
                                            </a></td>
                                            <?php $sum_mouns += $pluss->value; ?>
                                        </tr>
                                        @endif
                                                               
                                        @empty
                                            <td colspan="4">
                                                <div class="text-center">{{ __('translation.No_Data_Was_Found') }} </div>
                                            </td>
                                        @endforelse

                                       
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;">
                                            

                                            
                                            <td>{{ __('translation.total') }}:</td> 
                                            <td><span class='badge badge-danger'>{{ number_format($sum_mouns, 2) }}</span></td>
                                            <td><span class='badge badge-success'>{{ number_format($sum_pluss, 2) }}</span></td>
                                            
                                            <td><span class='badge badge-warning'>{{ number_format($sum_pluss - $sum_mouns, 2) }}</span></td>
                                            <td id = "end_colum"></td>
                                           
                                        </tr>
                                    </tbody>
                                </table>

                             
                            </div><!-- end of table responsive -->
                        </div><!-- end of col -->
                    </div><!-- end of row -->
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@push('scripts')


<script type="text/javascript">
    function printDiv() {
        var pro_id = document.getElementById("pro_id").value;
        // console.log(pro_id);
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        document.title = pro_id;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

</script>
@endpush
