

@extends('layouts.school.master')
@section('main-head', __('translation.Admin Dashboard'))
@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Toolbar-->
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('School.All_Teachers.index') }}" class="card bg-warning hoverable card-xl-stretch mb-xl-8" style="background-color: #033541 !important";>
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <div class="d-flex justify-content-around algin-items-centers">
                                <span class="svg-icon svg-icon-primary svg-icon-5x ms-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16" style="color: #ffffff !important;">
                                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                      </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                       {{-- {{$employe}} --}}
                                       @if ($employe === null)
                                       0
                                       @else
                                       {{$employe}}
                                       @endif
                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.Teachers_number') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>


                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('School.spending.index', ['service_id' => 1]) }}" class="card bg-primary hoverable card-xl-stretch mb-5 mb-xl-8" style="background-color: #d8fa2c !important";>
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
                            <div class="d-flex justify-content-around algin-items-center">
                                <div class="">
                                    <span class="svg-icon svg-icon-white svg-icon-4x ms-n1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z" fill="black"></path>
                                            <path d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </div>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                        {{ $spendings[0]->sum }}
                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.spendings') }}</div>
                                </div>

                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('admin.finanical') }}" class="card bg-success hoverable card-xl-stretch mb-xl-8" style="background-color: #61f041 !important";>
                        <!--begin::Body-->

                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->

                            <div class="d-flex justify-content-around">
                                <div class="">
                                    <span class="svg-icon svg-icon-white svg-icon-4x ms-n1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3" d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z" fill="black"></path>
                                            <path d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z" fill="black"></path>
                                        </svg>
                                    </span>
                                </div>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                       {{-- {{$FinancialTreasury[0]->sum}} --}}
                                       @if ($FinancialTreasury[0]->sum === null)
                                       0.00
                                       @else
                                       {{number_format($FinancialTreasury[0]->sum, 2)}}
                                       @endif
                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.current_treasury') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>
            <div style="padding: 10px 0px 0px 0px;">
            <div class="row g-5 g-xl-8">
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('School.Teachers_allowances.index') }}" class="card bg-warning hoverable card-xl-stretch mb-xl-8" style="background-color: #4551f7 !important";>
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <div class="d-flex justify-content-around algin-items-centers">
                                <span class="svg-icon svg-icon-primary svg-icon-5x ms-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-emoji-wink" viewBox="0 0 16 16" style="color: #ffffff !important;">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm1.757-.437a.5.5 0 0 1 .68.194.934.934 0 0 0 .813.493c.339 0 .645-.19.813-.493a.5.5 0 1 1 .874.486A1.934 1.934 0 0 1 10.25 7.75c-.73 0-1.356-.412-1.687-1.007a.5.5 0 0 1 .194-.68z"/>
                                      </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                                {{number_format($S,2)}}


                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.employee_allowances') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>


                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('Employee.Advances.index', ['service_id' => 1]) }}" class="card bg-primary hoverable card-xl-stretch mb-5 mb-xl-8" style="background-color: #e58080 !important";>
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
                            <div class="d-flex justify-content-around algin-items-center">
                                <div class="">
                                    <span class="svg-icon svg-icon-white svg-icon-4x ms-n1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-wallet2" viewBox="0 0 16 16" style="color: #ffffff !important;">
                                            <path d="M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.432-1.499L12.136.326zM5.562 3H13V1.78a.5.5 0 0 0-.621-.484L5.562 3zM1.5 4a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
                                          </svg>
                                    </span>
                                </div>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                        @if ($Advances[0]->sum === null)
                                        0.00
                                        @else
                                        {{number_format($Advances[0]->sum ,2)}}
                                        @endif
                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.Advancess') }}</div>
                                </div>

                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="{{ route('School.salaries.index', ['service_id' => 1]) }}" class="card bg-success hoverable card-xl-stretch mb-xl-8" style="background-color: #f2c122 !important";>
                        <!--begin::Body-->

                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->

                            <div class="d-flex justify-content-around">
                                <div class="">
                                    <span class="svg-icon svg-icon-white svg-icon-4x ms-n1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16" style="color: #fbf9f9 !important;">
                                            <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                                            <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                                            <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                                            <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                                          </svg>
                                    </span>
                                </div>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                      @if ($salaries[0]->sum === null)
                                      0.00
                                      @else
                                      {{$salaries[0]->sum}}
                                      @endif

                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.salaries') }} </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>
        </div>




                <div class="padding: 10px 0px 0px 0px;" style="
                padding: 18px;
            ">

            <div class="row mb-3">
                <div class="col-xl-6 col-lg-6 col-12">
                    <div class="card pull-up mt-2">
                        <div class="card-content">
                            <div class="card-body">
                                <canvas id="myChart" width="600" height="400"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-12">
                    <div class="card pull-up mt-2">
                        <div class="card-content">
                            <div class="card-body" style='d-flex justify-content-center'>
                                <div class="chart-container" style="position: relative; height:50vh; max-width:350px;">
                                <canvas id="myChart2" width="600" height="400"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row g-5 g-xl-8">
                <div class="box box-solid ">
                    <div class="card pull-up p-3">
                        <div class="box-header">
                            <h3 class="box-title">{{__('translation.spendings_Graph')}}</h3>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                            <div class="box-body border-radius-none">
                                <div class="chart" id="spendings_data" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                    <!-- /.box-body -->

            </div>
            <!--begin::Row-->
            <!--begin::Modal - New Product-->

        </div>
    </div>
</div>
{{-- @endsection --}}

</div>

@endsection



   <script src="{{ asset('datatable/chart.js') }}"></script>




@push('scripts');
<script src="{{ asset('admin_assets/js/custom/index.js')}}"></script>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('admin_assets/plugins/morris.min.js') }}"></script>
<script>

    //line chart
    var line = new Morris.Line({
        element: 'spendings_data',
        resize: true,
        data: [
            @foreach ($spendings_data as $data)
            {
                ym: "{{ $data->year }}-{{ $data->month }}", sum: "{{ $data->sum }}"
            },
            @endforeach
        ],
        xkey: 'ym',
        ykeys: ['sum'],
        labels: ['@lang('site.total')'],
        lineWidth: 2,
        hideHover: 'auto',
        gridStrokeWidth: 0.4,
        pointSize: 4,
        gridTextFamily: 'Open Sans',
        gridTextSize: 10
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

            const  data = @json($chartOne);
            const labels = data.map(item => item.label);
            const CartData = {
                labels: labels,
                datasets: [{
                label: '{{__('translation.chart_of_spending')}}',
                backgroundColor: 'rgb(30, 159, 242)',
                borderColor:'rgb(30, 159, 242)' ,
                data: data.map(item => item.Data),
                }]
            };

                const config = {
                type: 'line',
                data: CartData,
                clip:2,
                };


                const myChart = new Chart(
                document.getElementById('myChart'),
                config
                );


                const  array = @json($charttwo);
                // cahrt tow option -----------------------------------------
                const labels2 =  array.map(item => item.label);
                console.log(array, labels2);
                const CartData2 = {
                labels: labels2,
                datasets: [{
                label:'{{__('translation.chart_of_bar_chart')}}',

                backgroundColor: [

                      'rgb(255 ,145, 73,0.5)',
                      'rgb(102 ,110, 232,0.5)',
                      'rgb(40, 208, 148,0.5)' ,
                        'rgba(253, 73, 97, 0.5)',
                ],
                // borderColor:[
                //     'rgb(40, 208, 242 )' ,
                //     'rgba(102, 110, 232)',
                //     'rgb(30, 159, 242)',
                //     'rgba(253, 73, 97)',

                // ] ,
                size:400,
                data: array.map(item => item.Data),
                }]
            };

                const config2 = {
                    type: 'pie',
                    data: CartData2,

                };



                const myChart2 = new Chart(
                document.getElementById('myChart2'),
                config2
                );
  </script>
@endpush
