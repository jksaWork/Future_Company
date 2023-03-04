{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('title')
   {{__('translation.Staff_list')}}
@stop
@section('main-head', __('translation.employees'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
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
                    <form action="{{ route('reports.employee.report') }}"  >
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
                                id="example1" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>{{ __('translation.id') }}</th>
                                        <th scope="row">{{ __('translation.name') }}</th>
                                        <th scope="row">{{ __('translation.email') }}</th>
                                        <th scope="row">{{ __('translation.phone') }}</th>
                                        <th scope="row">{{ __('translation.address') }}</th>
                                        <th scope="row">{{ __('translation.salary') }}</th>
                                        <th scope="row"> {{ __('translation.Category') }}</th>
                                        <th scope="row"> {{ __('translation.allowances_id') }}</th>
                                        <th class="">{{ __('translation.status') }}</th>
                                        <th scope="row">{{ __('translation.description') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-bold text-gray-600">
                                    <?php $sum_employees_value = 0; ?>
                                    <?php $sum_allowances_value = 0; ?>
                                   
                                    @forelse ($employee as $index=>$employees)
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $employees->name }}</td>
                                            <td>{{ $employees->email }}</td>
                                                <td>{{ $employees->phone }}</td>
                                                <td>{{ $employees->address }}</td> 
                                                <td><span class='badge badge-warning'>{{ number_format($employees->salary, 2) }}</span>
                                                   
                                            </td>
                                           
                                                <td>{{ $employees->Categorys->categories_name }}</td>
                                               <td> @forelse ($allowancesS as $inde=>$allowanc)
                                                @if ($allowanc->employee_id == $employees->id)
                                                <?php $sum_allowances_value += $allowanc->Allowances_id->allowances_value; ?>
                                               {{ $allowanc->Allowances_id->allowances_name }}
                                                ({{ number_format($allowanc->Allowances_id->allowances_value, 2) }})<br>
                                                @endif
                                                
                                                @empty{{ __('translation.No_Data_Was_Found') }} @endforelse
                                               </td>
                                            <td>{{ $employees->getActive() }}</td>

                                                <td>{{ $employees->description }}</td>
                                        </tr>
                                        <?php $sum_employees_value += $employees->salary; ?>
                                       
                                    @empty
                                        <td colspan="4">
                                            <div class="text-center">{{ __('translation.No_Data_Was_Found') }}</div>
                                        </td>
                                    @endforelse
                                    
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;">
                                            

                                        <td>{{ __('translation.total') }}:</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> 
                                    <td>{{ number_format($sum_employees_value, 2) }}</td>
                                    <td></td>
                                    <td>{{ number_format($sum_allowances_value, 2) }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                </tr>
                                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200" style="text-align: center;">
                                            

                                    <td>{{ __('translation.all_total') }}:</td>
                                <td><span class='badge badge-success'>{{ number_format($sum_allowances_value +  $sum_employees_value , 2) }}<span class='badge badge-success'> </td>
                                <td></td>
                                <td></td>
                                <td></td> 
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>

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
</script>
@endpush
