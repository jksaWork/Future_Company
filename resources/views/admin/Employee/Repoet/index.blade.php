@extends('layouts.admin.admin')
@section('css')
    <style>
        @media print {
            #print_Button {
                display: none;
            }
            #form{
                display: none;
            }
        }

    </style>
@endsection
@section('title')
   {{__('translation.spending_list')}}
@stop
@section('main-head', __('translation.spending_report'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card" id="print">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    {{-- <div class="card-title"> --}}
                    <!--begin::Search-->
                    <div class="d-flex justify-conetnt-between align-items-center position-relative my-1 col-md-8">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                       
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
                    <form action="{{ route('reports.spending.report') }}"  id='form'>
                        <div class="form-group row" >
                       
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
                                        <tr>
                                            <th>{{ __('translation.id') }}</th>
                                            <th class="">{{ __('translation.spending_name') }}</th>
                                            <th class="">{{ __('translation.section_id') }}</th>
                                            <th class="">{{ __('translation.month') }}</th>
                                            <th class="">{{ __('translation.created_at') }}</th>
                                            <th class="">{{ __('translation.description') }}</th>
                                            <th class="">{{ __('translation.spending_value') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600">
                                        <?php $sum_spendings_value = 0; ?>
                                        @forelse ($spendings as $index=>$spendings)
                                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;">
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $spendings->spending_name }}</td>
                                                <td>{{ $spendings->section->section_name }}</td>
                                                <td>{{ $spendings->month}}</td> 
                                                <td>{{ $spendings->created_at}}</td>
                                                <td>{{ $spendings->description}}</td>
                                                <td>{{ $spendings->spending_value}}</td>
                                            </tr>

                                            <?php $sum_spendings_value += $spendings->spending_value; ?>
                                                               
                                        @empty
                                            <td colspan="4">
                                                <div class="text-center">{{ __('translation.No_Data_Was_Found') }} </div>
                                            </td>
                                        @endforelse
                                       
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;">
                                            

                                            <td></td>
                                            <td></td>
                                            <td></td> 
                                            <td></td>
                                            <td></td>
                                            <td>{{ __('translation.total') }}:</td>
                                            <td><span class='badge badge-success'>{{ number_format($sum_spendings_value, 2) }}</span></td>

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
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

</script>
@endpush
