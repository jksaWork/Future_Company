{{-- @extends('layouts.school.master') --}}
@extends('layouts.school.master')
@section('main-head', __('translation.spending'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <div class="p-2 m-2">
                    <div class="row p-3 m-2">
                        <div class="form-group col-md-6">
                            <label for="">{{ __('translation.being_month') }}</label>
                            <input type="date" name='being_month'  id ="being_month" class="form-control mb-2 mb-md-0" value="{{date('Y-M-D')}}"/>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="">{{ __('translation.end_month') }}</label>
                            <input type="date" name='end_month' value="{{ date('Y-m-d') }}" id ="end_month" class="form-control mb-2 mb-md-0" placeholder="Enter contact number" />
                     
                    </div>
               </div>
                   </div>
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    {{-- <div class="card-title"> --}}
                    <!--begin::Search-->
                    <div class="d-flex justify-conetnt-between align-items-center position-relative my-1 col-md-8">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <div class="col-md-6  d-flex align-items-center position-relative my-1 ">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="black" />
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            {{-- <form action="{{ route('owners.index')}}" method="get"> --}}
                            <input type="text" name='search' id="handelSearch" value="{{ request()->search }}"
                                class="form-control form-control-solid  ps-15"
                                placeholder="{{ __('translation.search_with_number_or_name_description_month_spending_value') }}" />

                        </div>
                        {{-- </form> --}}
                        <div class="d-flex mr-3" style="
                        margin: auto;
                    ">
                            <div class="form-group">
                                <select class="form-control" name="" id="school_spendings">
                                    <option value="" selected disabled> {{ __('translation.Choose_school_id') }}
                                    </option>
                                    @foreach ($school_id as $school_id)
                                        <option  value="{{ $school_id->id }}">{{ $school_id->school_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        {{-- <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <a href='{{ route('School.spending.create', ['type' => request()->type]) }}'
                                class="btn btn-primary">{{ __('translation.Add') }}</a>
                        </div> --}}
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-customer-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger"
                                data-kt-customer-table-select="delete_selected">Delete Selected</button>
                        </div>
                        <!--end::Group actions-->
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    @include('layouts.includes.session')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                    id="roles-table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('translation.id') }}</th>
                                            <th class="">{{ __('translation.spending_name') }}</th>
                                            <th class="">{{ __('translation.spending_value') }}</th>
                                            <th class="">{{ __('translation.school_name') }}</th>
                                            <th class="">{{ __('translation.section_id') }}</th>
                                            <th class="">{{ __('translation.created_at') }}</th>
                                            <th class="">{{ __('translation.description') }}</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class='table-success'>
                                            <th colspan="2" style="text-align:center">{{ __('translation.total') }} : </th>
                                            <th id='spending_total' style="font-weight:bolder">0</th>
                                        </tr>
                                    </tfoot>
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

<script src="{{ asset('datatable/select2.min.js') }}"></script>

<script>

   $.fn.dataTable.ext.classes.sPageButton= 'paginate_button page-item';
   $.fn.dataTable.ext.classes.sPageButtonActive= 'paginate_button page-item active';
   let stauts, type, school_spendings, end_month,being_month, id = @json(request()->id);
   let role;
   let rolesTable = $('#roles-table').DataTable({
   
       dom: "Brtp",
       serverSide: true,
       processing: true,
       distroy: true,
       "language": {
           "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
       },
       buttons: [
           'copy', {
               extend:'excel',
               text:'{{ __('translation.export_As_exel') }}' ,
           },

           { extend: 'print',
                   title: '@lang('translation.spending')',
                   className: 'btn btn-default',
                   autoPrint: true,

                   customize: function (win) {
                       $(win.document.body).css('direction', 'rtl');
                       $(win.document.body).find('th').addClass('display').css('text-align', 'center');
                       $(win.document.body).find('table').addClass('display').css('font-size', '16px');
                       $(win.document.body).find('table').addClass('display').css('text-align', 'center');
                       $(win.document.body).find('tr:nth-child(odd) td').each(function (index) {
                           $(this).css('background-color', '#D0D0D0');
                       });
                       $(win.document.body).find('h1').css('text-align', 'center');
                       $(win.document.body).find('tfoot').css('color', 'red');
                   }
                }

       ]  ,
         ajax: {
            url: '{{ route('School_reports.School_spending.report.data') }}',
           data: function(q) {
               q.type = type;
               q.school_spendings = school_spendings;
               q.being_month = being_month;
               q.end_month = end_month;
         

           },
       },

       columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'spending_name',
                    name: 'spending_name'
                },

                {
                    data: 'spending_value',
                    name: 'spending_value'
                },
                {
                    data: 'school_id',
                    name: 'school_id'
                },
                {
                    data: 'section_id',
                    name: 'section_id'
                },

                {
                    data: 'month',
                    name: 'month'
                },
                {
                    data: 'description',
                    name: 'description'
                },
              


               
            ],
       order: [
           [2, 'desc']
       ],

       footerCallback: function (row, data, start, end, display) {
        // console.log(footerCallback);
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };
            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);


            $(api.column(2).footer()).html(`${new Intl.NumberFormat().format(pageTotal)}`);
        },
   });
  
   $('#handelSearch').keyup(function() {
       rolesTable.search(this.value).draw();

   });
 
   $('#end_month').on('change', function() {
    end_month = $(this).val();
    console.log(end_month);
     rolesTable.ajax.reload();
});

$('#being_month').on('change', function() {
    being_month = $(this).val();
    console.log(being_month);
     rolesTable.ajax.reload();
});

   $('#realstate').on('change', function() {
       type = $(this).val();
       rolesTable.ajax.reload();
   });
   $('#school_spendings').on('change', function() {
    school_spendings = $(this).val();
       console.log(school_spendings);
       rolesTable.ajax.reload();
   });
   $('#from_date').on('change', function() {
       from_date = $(this).val();
       console.log(from_date);
       rolesTable.ajax.reload();
   });
  
</script>

@endpush
