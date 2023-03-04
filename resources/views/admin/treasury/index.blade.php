{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head', __('translation.treasury'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl mt-1">
            <!--begin::Card-->
            <div class="row g-5 g-xl-8">
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-dark hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen032.svg-->
                            <div class="d-flex justify-content-around algin-items-centers">
                                <span class="svg-icon svg-icon-primary svg-icon-5x ms-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none">
                                        <rect x="8" y="9" width="3" height="10" rx="1.5"
                                            fill="black"></rect>
                                        <rect opacity="0.5" x="13" y="5" width="3" height="14"
                                            rx="1.5" fill="black"></rect>
                                        <rect x="18" y="11" width="3" height="8" rx="1.5"
                                            fill="black"></rect>
                                        <rect x="3" y="13" width="3" height="6" rx="1.5"
                                            fill="black"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                        {{ number_format($Treasury->total_credit, 2) }}
                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.all_revenues') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>


                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-primary hoverable card-xl-stretch mb-5 mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/graphs/gra007.svg-->
                            <div class="d-flex justify-content-around algin-items-center">
                                <div class="">
                                    <span class="svg-icon svg-icon-white svg-icon-4x ms-n1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M10.9607 12.9128H18.8607C19.4607 12.9128 19.9607 13.4128 19.8607 14.0128C19.2607 19.0128 14.4607 22.7128 9.26068 21.7128C5.66068 21.0128 2.86071 18.2128 2.16071 14.6128C1.16071 9.31284 4.96069 4.61281 9.86069 4.01281C10.4607 3.91281 10.9607 4.41281 10.9607 5.01281V12.9128Z"
                                                fill="black"></path>
                                            <path
                                                d="M12.9607 10.9128V3.01281C12.9607 2.41281 13.4607 1.91281 14.0607 2.01281C16.0607 2.21281 17.8607 3.11284 19.2607 4.61284C20.6607 6.01284 21.5607 7.91285 21.8607 9.81285C21.9607 10.4129 21.4607 10.9128 20.8607 10.9128H12.9607Z"
                                                fill="black"></path>
                                        </svg>
                                    </span>
                                </div>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                        {{ number_format($Treasury->total_debit, 2) }}
                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.spending') }}</div>
                                </div>

                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Statistics Widget 5-->
                    <a href="#" class="card bg-success hoverable card-xl-stretch mb-xl-8">
                        <!--begin::Body-->

                        <div class="card-body">
                            <!--begin::Svg Icon | path: icons/duotune/finance/fin006.svg-->

                            <div class="d-flex justify-content-around">
                                <div class="">
                                    <span class="svg-icon svg-icon-white svg-icon-4x ms-n1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none">
                                            <path opacity="0.3"
                                                d="M20 15H4C2.9 15 2 14.1 2 13V7C2 6.4 2.4 6 3 6H21C21.6 6 22 6.4 22 7V13C22 14.1 21.1 15 20 15ZM13 12H11C10.5 12 10 12.4 10 13V16C10 16.5 10.4 17 11 17H13C13.6 17 14 16.6 14 16V13C14 12.4 13.6 12 13 12Z"
                                                fill="black"></path>
                                            <path
                                                d="M14 6V5H10V6H8V5C8 3.9 8.9 3 10 3H14C15.1 3 16 3.9 16 5V6H14ZM20 15H14V16C14 16.6 13.5 17 13 17H11C10.5 17 10 16.6 10 16V15H4C3.6 15 3.3 14.9 3 14.7V18C3 19.1 3.9 20 5 20H19C20.1 20 21 19.1 21 18V14.7C20.7 14.9 20.4 15 20 15Z"
                                                fill="black"></path>
                                        </svg>
                                    </span>
                                </div>
                                <!--end::Svg Icon-->
                                <div class="">
                                    <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                                        {{ number_format($Treasury->total, 2) }}
                                    </div>
                                    <div class="fw-bold text-white fs-4">{{ __('translation.current_treasury') }}</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </a>
                    <!--end::Statistics Widget 5-->
                </div>
            </div>
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    {{-- <div class="card-title"> --}}
                    <div class="row col-md-9">
                        <div class="col-md-4">
                            <div class="">
                                <div class="form-group">
                                    <label class='form-lable'> {{ __('translation.type') }}</label>
                                    <select id='realstate' style='width:100%' name='realstate_id' class='form-control'>
                                        <option value=''> {{ __('translation.all_types') }}</option>
                                        <option value='credit'> {{ __('translation.credit_types') }}</option>
                                        <option value='debit'> {{ __('translation.debit_types') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="">
                                <div class="form-group">
                                    <label class='form-lable'> {{ __('translation.transaction_type') }}</label>
                                    <select id='owner' style='width:100%' name='transaction_type'
                                        class='form-control'>
                                        @foreach (\App\Models\FinancialTreasuryTransactionHistorys::TYPES as $transaction_type => $type)
                                            <option value='{{ $transaction_type }}'>
                                                {{ __('translation.' . $transaction_type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">{{ __('translation.from_date') }}</label>
                                <input id='from_date' type="date" class="form-control form-control-solid"
                                    name="" id="" aria-describedby="helpId" placeholder="" />
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
                            <a href='#' data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer"
                                class="btn btn-primary ">{{ __('translation.add_amount_from_main') }}</a>
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
                                            <th>{{ __('translation.transaction_id') }}</th>
                                            <th>{{ __('translation.trans_type') }}</th>
                                            <th>{{ __('translation.transaction_type') }}</th>
                                            <th>{{ __('translation.amount') }}</th>
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
                    <form class="form" action="{{ route('admin.finanical.store') }}" method="post">
                        @csrf
                        <!--begin::Modal header-->
                        <div class="modal-header" id="kt_modal_add_customer_header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bolder">{{ __('translation.add_real_state_category') }}</h2>
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
                                <x:text-input name='amount' class='col-md-12' />
                                <!--end::Input group-->
                                <x:text-area class='col-md-12' name='note'></x:text-area>
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
                            <button class="btn btn-primary"> {{ __('translation.add_to_trnsury') }} </button>
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

        $.fn.dataTable.ext.classes.sPageButton= 'paginate_button page-item';
        $.fn.dataTable.ext.classes.sPageButtonActive= 'paginate_button page-item active';
        let stauts, type, transaction_type, from_date, id = @json(request()->id);
        let rolesTable = $('#roles-table').DataTable({
            dom: "tiplr",
            serverSide: true,
            processing: true,
            distroy: true,
            "language": {
                "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },
            ajax: {
                url: '{{ route('admin.finanical.data') }}',
                data: function(q) {
                    q.type = type;
                    q.transaction_type = transaction_type;
                    q.from_date = from_date;
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
                    data: 'type',
                    name: 'type',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'transaction_type',
                    name: 'transaction_type',
                    searchable: false,
                    sortable: false
                },

                {
                    data: 'amount',
                    name: 'amount',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'note',
                    name: 'note',
                    searchable: false,
                    sortable: false
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
