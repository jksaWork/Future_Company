{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head' , __('translation.owners_dashboard'))
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                        <span class="svg-icon svg-icon-1 position-absolute ms-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                    height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                    fill="black" />
                                <path
                                    d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                    fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        {{-- <form action="{{ route('owners.index')}}" method="get"> --}}
                            <input type="text"  name='search'
                            id="handelSearch"
                            value="{{request()->search}}"
                            class="form-control form-control-solid w-350px ps-15"
                            placeholder="{{__('translation.search_with_number_or_name_email')}}" />
                        {{-- </form> --}}
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <a href='{{ route('realstate.realstate.create' , ['type' => request()->type])}}' class="btn btn-primary" >{{__('translation.add_real_state')}}</a>
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none"
                        data-kt-customer-table-toolbar="selected">
                        <div class="fw-bolder me-5">
                            <span class="me-2"
                                data-kt-customer-table-select="selected_count"></span>Selected
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer" id="roles-table" style="width: 100%;">
                                <thead>
                                    <tr>

                                        <th>{{__('translation.id')}}</th>
                                        <th>{{__('translation.title')}}</th>
                                        <th>{{__('translation.realstate_number')}}</th>
                                        <th>{{__('translation.address')}}</th>
                                        <th>{{__('translation.price')}}</th>
                                        <th>{{__('translation.type')}}</th>
                                        <th>{{__('translation.category')}}</th>
                                        <th>{{__('translation.status')}}</th>  {{-- جاهز ولا م جاهز --}}
                                        <th>{{true ? __('translation.is_saled') : __('translation.is_rented')}}</th>  {{-- جاهز ولا م جاهز --}}

                                        <th>@lang('translation.created_at')</th>
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
<script src="{{ asset('admin_assets/js/custom/index.js') }}"></script>
<script>
    let role;
    let rolesTable = $('#roles-table').DataTable({
        dom: "tiplr",
        serverSide: true,
        processing: true,
        "language": {
            "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
        },
        ajax: {
            url: '{{ route('realstate.data') }}',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'realstate_number', name: 'realstate_number'},
            {data: 'address', name: 'address'},
            {data: 'price', name: 'price' },
            {data: 'type', name: 'type' },
            {data: 'category_id', name: 'category_id' ,searchable: false},
            {data: 'status', name: 'status',  sortable:false},
            {data: 'is_sale', name: 'is_sale',  sortable:false},
            {data: 'created_at', name: 'created_at', searchable: false},
            {data: 'actions', name: 'actions', searchable: false, sortable: false, width: '20%'},
        ],
        order: [[2, 'desc']],
        drawCallback: function (settings) {
            $('.record__select').prop('checked', false);
            $('#record__select-all').prop('checked', false);
            $('#record-ids').val();
            $('#bulk-delete').attr('disabled', true);
        }
    });

    $('#handelSearch').keyup(function () {
        rolesTable.search(this.value).draw();
        // role = $(this).val();
        // rolesTable.ajax.reload();
    });
    $('#roles').on('change' , function(){
        role = $(this).val();
        rolesTable.ajax.reload();
    });
</script>
@endpush
