@extends('layouts.school.master')
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
{{__('translation.salaries_list')}}
@stop
@section('main-head', __('translation.salaries_report'))
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
            <div class="card-body pt-0" >
                <div class="d-flex flex-stack pb-10">
                    <!--begin::Logo-->
                    <a href="#"> </a>
                    <!--end::Logo-->
                    <!--begin::Action-->
                    <a href="#" class="btn btn-sm btn-success" id="print_Button" onclick="printDiv()">{{ __('translation.print') }}</a>
                    <!--end::Action-->
                </div>
                <form action="{{ route('reports.salaries.report') }}" id='form'>
                    <div class="form-group row">

                        <div class="col-md-3">
                            <label class="form-label">{{ __('translation.being_month') }}:</label>
                            <input type="date" name='being_month' class="form-control mb-2 mb-md-0" value="{{date('Y-M-D')}}" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('translation.end_month') }}:</label>
                            <input type="date" name='end_month' value="{{ date('Y-m-d') }}" class="form-control mb-2 mb-md-0" placeholder="Enter contact number" />
                        </div>

                        <div class="col-md-6" style="
                            text-align: -webkit-auto;
                            padding: 26px;
                        ">
                            <button class="btn btn-primary"> {{ __('translation.search') }}
                            </button>
                        </div>


                    </div>
                </form><br><br><br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover table-rounded table-striped border gy-7 gs-7"  >
                                <thead>
                                    <tr>
                                        <th>{{ __('translation.id') }}</th>
                                        <th class="">{{ __('translation.school_type') }}</th>
                                        <th class="">{{ __('translation.employee_name') }}</th>
                                            <th class="">{{ __('translation.fixed_salary') }}</th>
                                            <th class="">{{ __('translation.allownacees_salary') }}</th>
                                            <th class="">{{ __('translation.advances') }}</th>
                                            <th class="">{{ __('translation.discounts') }}</th>
                                            <th class="">{{ __('translation.status') }}</th>
                                            <th class="">{{ __('translation.month') }}</th>
                                            <th class="">{{ __('translation.totle_salaries') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">

                                    <?php $sum_salaries = 0; ?>
                                    @forelse ($salaries as $index=>$salaries)
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;" >
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $salaries->School->school_name }}</td>
                                        <td>{{ $salaries->teachers->name }}</td>
                                        <td> {{ number_format($salaries->fixed_salary,2) }}</td>
                                        <td>{{ number_format($salaries->allowancess_fixed, 2) }}</td>
                                        <td><span class='badge badge-danger'>{{ number_format($salaries->advances,2) }}</span></td>
                                        <td><span class='badge badge-danger'>{{ number_format($salaries->discounts, 2) }}</span></td>
                                        <td>{{ $salaries->getActive() }}</td>
                                        <td>{{ __('translation.Month')}}-{{ $salaries->month_number}}</td>
                                    <td><span class='badge badge-success'>{{ number_format($salaries->totle_salaries, 2) }}</span></td>
                                    </tr>
                                    <?php $sum_salaries += $salaries->totle_salaries; ?>
                                    @empty
                                    <td colspan="4">
                                        <div class="text-center">{{ __('translation.No_Data_Was_Found') }}</div>
                                    </td>
                                    @endforelse

                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;" >

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{ __('translation.total') }}:</td>
                                        <td><span class='badge badge-success'>{{ number_format($sum_salaries , 2) }}<span class='badge badge-success'> </td>

                                       

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




<!-- jQuery -->
{{-- 

<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('datatable/jquery.js') }}"></script>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/custom/index.js') }}"></script> --}}

<!-- DataTables  & Plugins -->
{{-- <script src="{{URL::asset('datatable/js/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-bs4/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-responsive/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-responsive/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/jszip/jszip.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-buttons/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-buttons/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('datatable/js/datatables-buttons/buttons.colVis.min.js')}}"></script>

<!-- AdminLTE App -->

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
@endpush --}}