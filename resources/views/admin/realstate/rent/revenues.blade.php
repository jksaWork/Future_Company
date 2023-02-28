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
                        <div class="col-md-4">
                            <div class="">
                                <div class="form-group">
                                    <label class='form-lable'> {{ __('translation.status') }}</label>
                                    <select id='status' style='width:100%' name='realstate_id'>
                                        <option value='1'> {{ __('translation.revened') }}</option>
                                        <option value='0'> {{ __('translation.unrevened') }}</option>
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
                                            <th>{{ __('translation.month_count') }}</th>
                                            <th>{{ __('translation.form_date') }}</th>
                                            <th>{{ __('translation.status') }}</th>
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
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    <script src="{{ asset('datatable/jquery.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin_assets/js/custom/index.js') }}"></script>

    {{-- <script src="{{ asset('datatable/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('datatable/select2.min.js') }}"></script>

    <script>
        let stauts, realstate_id, owner_id , id = @json(request()->id);
        let rolesTable = $('#roles-table').DataTable({
            dom: "tiplr",
            serverSide: true,
            processing: true,
            distroy: true,
            "language": {
                "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },
            ajax: {
                url: '{{ route('realstate.recept_revenues.data') }}',
                data: function(q) {
                    q.status = $('#status').val();;
                    q.realstate_id = realstate_id;
                    q.owner_id = owner_id;
                    q.id = id;
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
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'month_number',
                    name: 'month_number',
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    sortable: false
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
        $('#status').on('change', function() {
            status = $(this).val();
            rolesTable.ajax.reload();
            console.log('form here');
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
@endpush
