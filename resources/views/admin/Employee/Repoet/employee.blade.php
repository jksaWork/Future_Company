
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
   {{__('translation.Staff_list')}}
@stop
@section('main-head', __('translation.employees_report'))
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
                    <form action="{{ route('reports.employee.report') }}" id='form' >
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
                                    <td><span class='badge badge-success'>{{ number_format($sum_employees_value, 2) }}</span></td>
                                    <td></td>
                                    <td><span class='badge badge-success'>{{ number_format($sum_allowances_value, 2) }}</span></td>
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
