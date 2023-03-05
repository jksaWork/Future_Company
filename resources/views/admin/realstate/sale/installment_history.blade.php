{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head', __('translation.revenues_history'))
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
                    <div class="row col-md-9">
                        <div class="col-md-4">
                            <div class="">
                                <div class="form-group">
                                    <label class='form-lable'> {{ __('translation.realstate') }}</label>
                                    <select id='realstate' style='width:100%' name='realstate_id'>
                                        <option value='0'> {{ __('translation.chose_your_real_state') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="">
                                <div class="form-group">
                                    <label class='form-lable'> {{ __('translation.owner') }}</label>
                                    <select id='owner' style='width:100%' name='owner_id'>
                                        <option value='0'> {{ __('translation.chose_your_real_state') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--begin::Search-->
                    {{-- </div> --}}
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    {{-- <div class="card-toolbar"> --}}

                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <a href='{{ route('realstate.receipt') }}'
                                class="btn btn-primary btn-sm">{{ __('translation.recept_revenues') }}</a>
                        </div>
                        {{-- </div> --}}
                        <!--end::Toolbar-->
                        <!--begin::Group actions-->
                        <div class="d-flex justify-content-end align-items-center d-none"
                            data-kt-customer-table-toolbar="selected">
                            <div class="fw-bolder me-5">
                                <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                            </div>
                            <button type="button" class="btn btn-danger"
                                data-kt-customer-table-select="delete_selected">Delete
                                Selected</button>
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
                                            <th>{{ __('translation.owner_name') }}</th>
                                            <th>{{ __('translation.owner_phone') }}</th>
                                            <th>{{ __('translation.real_state_title') }}</th>
                                            <th>{{ __('translation.address') }}</th>
                                            <th>{{ __('translation.price') }}</th>
                                            <th>{{ __('translation.installment_order') }}</th>
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
        </div>
        <!--end::Container-->
    </div>
@endsection
@push('scripts')
    {{-- <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('datatable/jquery.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom/index.js') }}"></script> --}}

    {{-- <script src="{{ asset('datatable/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('datatable/select2.min.js') }}"></script>

    <script>
        let stauts, realstate_id, owner_id, installment_id = @json(request()->id);
        let rolesTable = $('#roles-table').DataTable({
            dom: "Brtip",
            buttons: [
                'copy', {
                    extend:'excel',
                    text:'{{ __('translation.export_As_exel') }}' ,
                },

                { extend: 'print',
                        title: '@lang('translation.installment_history')',
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
            serverSide: true,
            processing: true,
            distroy: true,
            "language": {
                "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },
            ajax: {
                url: '{{ route('realstate.installment_hsitory.data') }}',
                data: function(q) {
                    q.realstate_id = realstate_id;
                    q.owner_id = owner_id;
                    q.id = installment_id
                },
            },

            columns: [{
                    data: 'id',
                    name: 'id',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'name',
                    name: 'name',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'phone',
                    name: 'phone',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                // {data: 'category_id', name: 'category_id' ,searchable: false},
                {
                    data: 'address',
                    name: 'address'
                },
                {
                    data: 'amount',
                    name: 'amount'
                },
                {
                    data: 'order_number',
                    name: 'order_number',
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    sortable: false,
                },
            ],
            order: [
                [2, 'desc']
            ]

        });

        $('#handelSearch').keyup(function() {
            rolesTable.search(this.value).draw();

        });


        $("#realstate").select2({
            ajax: {
                url: "{{ route('realstate.ajax') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $("#owner").select2({
            ajax: {
                url: "{{ route('owners.ajax') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $('#realstate').on('change', function() {
            realstate_id = $(this).val();
            rolesTable.ajax.reload();
            console.log(realstate_id);
        });

        $('#owner').on('change', function() {
            owner_id = $(this).val();
            rolesTable.ajax.reload();
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

$("#realstate").select2({
            ajax: {
                url: "{{ route('realstate.ajax') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $("#owner").select2({
            ajax: {
                url: "{{ route('owners.ajax') }}",
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });

        $('#realstate').on('change', function() {
            realstate_id = $(this).val();
            rolesTable.ajax.reload();
            console.log(realstate_id);
        });

        $('#owner').on('change', function() {
            owner_id = $(this).val();
            rolesTable.ajax.reload();
        });

    </script>
@endpush
