{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.school.master')
@section('main-head', __('translation.employee_allowances'))
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
                                placeholder="{{ __('translation.search_with_created_at') }}" />

                        </div>
                        {{-- </form> --}}
                        <div class="d-flex mr-3" style="
                        margin: auto;
                    ">
                            <div class="form-group">
                                <select class="form-control" name="" id="school_teachers_allowances">
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
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <a href='{{ route('School.Teachers_allowances.create', ['type' => request()->type]) }}'
                                class="btn btn-primary">{{ __('translation.Add') }}</a>
                        </div>
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
                                            <th class="">{{ __('translation.school_name') }}</th>
                                             <th class="">{{ __('translation.teachers_name') }}</th>
                                            <th class="">{{ __('translation.allowances_name') }}</th>
                                            <th class="">{{ __('translation.month_number') }}</th>
                                            <th class="">{{ __('translation.created_at') }}</th>
                                            <th>@lang('translation.action')</th>
                                        </tr>
                                    </thead>
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
   let stauts, type, school_teachers_allowances, from_date, id = @json(request()->id);
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
                   title: '@lang('translation.employee_allowances')',
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
                   }}

       ]  ,
         ajax: {
            url: '{{ route('data.teachers_allowances.hitory.data') }}',
           data: function(q) {
               q.type = type;
               q.school_teachers_allowances = school_teachers_allowances;
               q.from_date = from_date;
               q.id = id;

           },
       },

       columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'school_id',
                    name: 'school_id'
                },
                {
                    data: 'teachers_id',
                    name: 'teachers_id'
                },

                {
                    data: 'allowances_id',
                    name: 'allowances_id'
                },
                {
                    data: 'month_number',
                    name: 'month_number'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },

                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    sortable: false,
                    width: '20%'
                },

            ],
                   order: [
           [2, 'desc']
       ]

   });

   $('#handelSearch').keyup(function() {
       rolesTable.search(this.value).draw();

   });

   $('#realstate').on('change', function() {
       type = $(this).val();
       rolesTable.ajax.reload();
   });
   $('#school_teachers_allowances').on('change', function() {
    school_teachers_allowances = $(this).val();
       console.log(school_teachers_allowances);
       rolesTable.ajax.reload();
   });
   $('#from_date').on('change', function() {
       from_date = $(this).val();
       console.log(from_date);
       rolesTable.ajax.reload();
   });
   $('input[name="amount"]').attr('type', 'number');
</script>
@endpush
