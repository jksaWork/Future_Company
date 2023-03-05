
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

   {{__('translation.employee_allowances_list')}}
@stop
@section('main-head', __('translation.employee_allowances_report'))
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
                    <form action="{{ route('reports.employee_allowances.report') }}" id='form' >
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
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                id="example1" >
                                <thead>
                                    <tr>
                                        <th>{{ __('translation.id') }}</th>
                                        <th class="">{{ __('translation.employee_name') }}</th>
                                        <th class="">{{ __('translation.created_at') }}</th>
                                        <th class="">{{ __('translation.allowances_name') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">

                                    <?php $sum_allowances_value = 0; ?>
                                    @forelse ($employee_allowances as $index=>$allowances)
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: -moz-right;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $allowances->employee->name }}</td>
                                             <td>{{ $allowances->created_at }}</td>
                                             <td> {{ $allowances->Allowances_id->allowances_name }} ({{ number_format($allowances->Allowances_id->allowances_value, 2) }})</td>
                                        </tr>
                                             <?php $sum_allowances_value += $allowances->Allowances_id->allowances_value; ?>
                                    @empty
                                        <td colspan="4">
                                            <div class="text-center">{{ __('translation.No_Data_Was_Found') }}</div>
                                        </td>
                                    @endforelse

                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: -moz-right;">


                                    <td></td>
                                    <td></td>
                                    <td>{{ __('translation.total') }}:</td>
                                    <td><span class='badge badge-success'>{{ number_format($sum_allowances_value , 2) }}<span class='badge badge-success'> </td>


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
 <!-- jQuery -->

{{-- 
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<script src="{{ asset('datatable/jquery.js') }}"></script>
<script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin_assets/js/custom/index.js') }}"></script>

<!-- DataTables  & Plugins -->
<script src="{{URL::asset('datatable/js/datatables/jquery.dataTables.min.js')}}"></script>
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
    $(function () {
        $("#example1").DataTable({
            "responsive": true, "lengthChange": false, "autoWidth": false,
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
</script> --}}

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
