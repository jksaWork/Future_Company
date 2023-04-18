{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.school.master')
@section('main-head', __('translation.supplier_mangements'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl mt-1">
            <!--begin::Card-->

            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    {{-- <div class="card-title"> --}}
                    <div class="row col-md-4">
                        <input type="text" name='search' id="handelSearch" value="{{ request()->search }}"
                        class="form-control form-control-solid  ps-15"
                        placeholder="{{ __('translation.name') }}" />

                    </div>
                    <!--begin::Search-->
                    {{-- </div> --}}
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    {{-- <div class="card-toolbar"> --}}

                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <a href='#' data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer"
                                class="btn btn-primary ">{{ __('translation.add_supplier') }}</a>
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
                    <div class="p-2">
                        @include('layouts.includes.session')
                    </div>
                    <div class="row">
                        <div class="col-md-12 pt-5">
                        <div class='dataTables_wrapper dt-bootstrap4 no-footer' >
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                    id="roles-table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('translation.supplier_id') }}</th>
                                            <th>{{ __('translation.name') }}</th>
                                            <th>{{ __('translation.note') }}</th>
                                            <th>{{ __('translation.created_at') }}</th>
                                            <th>@lang('translation.action')</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div><!-- end of table responsive -->
                        </div><!-- end of col -->
                    </div><!-- end of row -->
                    <!--end::Table-->
                </div>
            </div>
                <!--end::Card body-->
            </div>
        </div>
        {{-- Add MOdal --}}
        <div class="modal fade" id="kt_modal_add_customer" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Form-->
                    <form class="form" action="{{ route('supplier.store') }}" method="post">
                        @csrf
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_add_customer_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bolder">{{ __('translation.add_amount_from_main') }}</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                            <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect opacity="0.5" x="6" y="17.3137" width="16"
                                            height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                            fill="black" />
                                        <rect x="7.41422" y="6" width="16" height="2"
                                            rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                                    </svg>
                                </span>

                                <!--end::Svg Icon-->
                            </div>
                        </div>

                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body py-10 px-lg-17">
                            <!--begin::Scroll-->
                            <div class="scroll-y me-n7 pe-7" id="#">
                                <!--begin::Input group-->
                                <x:text-input name='name' class='col-md-12' />
                                <!--end::Input group-->
                                <x:text-area class='col-md-12' name='description'></x:text-area>
                                <!--begin::Input group-->
                            </div>
                            <!--end::Scroll-->
                        </div>
                        <!--end::Modal body-->
                        <!--begin::Modal footer-->
                        <div class="modal-footer ">
                            <!--begin::Button-->
                            <button type="reset"
                            data-bs-dismiss="modal" aria-label="Close"
                                class="btn btn-light me-3">{{ __('translation.cancel') }}</button>
                            <!--end::Button-->
                            <!--begin::Button-->
                            <button class="btn btn-primary"> {{ __('translation.add_supplier') }} </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Modal footer-->
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>
        {{-- end MOdal --}}
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
                url: '{{ route('supplier.data') }}',
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
                },
                {
                    data: 'description',
                    name: 'description',
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    sortable: false,
                    width: '30px',
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
