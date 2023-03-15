{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.school.master')
@section('main-head', $headings[request()->type] ?? '')
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
                                placeholder="{{ __('translation.search_student_name_guard_amount') }}" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                            <a href='{{ route('school.students.revenues.create', ['type' => request()->type]) }}'
                                class="btn btn-primary">{{ __('translation.recept_students_renvue') }}</a>
                        </div>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5">
                    @include('layouts.includes.session')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                    id="roles-table" >
                                    <thead>
                                        <tr>

                                            <th>{{ __('translation.id') }}</th>
                                            <th>{{ __('translation.student_name') }}</th>
                                            <th>{{ __('translation.student_guard') }}</th>
                                            <th>{{ __('translation.school_idd') }}</th>
                                            <th>{{ __('translation.amount') }}</th>
                                            <th>{{ __('translation.opration_type') }}</th>
                                            <th>{{ __('translation.opration_idd') }}</th>
                                            <th>{{ __('translation.revenue_type') }}</th>
                                            <th>{{ __('translation.recept_date') }}</th>
                                            {{-- <th>{{ __('translation.status') }}</th> جاهز ولا م جاهز --}}
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
        let stauts, type, transaction_type, from_date, id = @json(request()->id);
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
                        title: '@lang('translation.main_treasury')',
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
                url: '{{ route('school.students.revenues.data') }}',
                data: function(q) {
                    q.type = type;
                    q.transaction_type = transaction_type;
                    q.from_date = from_date;
                    q.id = id;

                },
            },

            columns: [
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'student_name',
                    name: 'student_name'
                },
                {
                    data: 'student_guard',
                    name: 'student_guard'
                },

                {
                    data: 'school_id',
                    name: 'school_id',
                },
                {
                    data: 'amount',
                    name: 'amount',
                },
                {
                    data: 'revenue_type',
                    name: 'revenue_type',
                    searchable: false
                },
                {
                    data: 'opration_id',
                    name: 'opration_id',
                    searchable: false
                },
                {
                    data: 'recept_date',
                    name: 'recept_date',
                    // sortable: false
                },

                {
                    data: 'recept_date',
                    name: 'recept_date',
                    searchable: false
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
        $('#owner').on('change', function() {
            transaction_type = $(this).val();
            console.log(transaction_type);
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

