{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.school.master')
@section('main-head', __('translation.treasury') . ' - ' . __('translation.spending'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl mt-1">
            <!--begin::Card-->
            <div class="row g-5 g-xl-8">

                <div class="col-xl-6">
                    <!--begin: Statistics Widget 6-->
                    <div class="card bg-light-warning card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body my-3">
                            <a href="#"
                                class="card-title fw-bolder text-warning fs-5 mb-3 d-block">{{ __('translation.speding_from_spending_school') }}</a>
                            <div class="py-1">
                                <span class="text-dark fs-1 fw-bolder me-2">{{ $spending_section }}%</span>
                                <span class="fw-bold text-muted fs-7">
                                    {{ __('translation.spending_ection_spneding_precntage_and_transffer') }}</span>
                            </div>
                            <div class="progress h-7px bg-warning bg-opacity-50 mt-7">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    style="width: {{ $spending_section . '%' }}" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end:: Body-->
                    </div>
                    <!--end: Statistics Widget 6-->
                </div>
                <div class="col-xl-6">
                    <!--begin: Statistics Widget 6-->
                    <div class="card bg-light-success card-xl-stretch mb-xl-8">
                        <!--begin::Body-->
                        <div class="card-body my-3">
                            <a href="#"
                                class="card-title fw-bolder text-success fs-5 mb-3 d-block">{{ __('translation.spending_for_techer_section') }}</a>
                            <div class="py-1">
                                <span class="text-dark fs-1 fw-bolder me-2">{{ $employee_section }}%</span>
                                <span
                                    class="fw-bold text-muted fs-7">{{ __('translation.spending_for_techer_section_desc') }}</span>
                            </div>
                            <div class="progress h-7px bg-success bg-opacity-50 mt-7">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $employee_section . '%' }}" aria-valuenow="50" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <!--end:: Body-->
                    </div>
                    <!--end: Statistics Widget 6-->
                </div>

            </div>
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    {{-- <div class="card-title"> --}}
                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <div class="">
                                <div class="form-group">
                                    <label class='form-lable'> {{ __('translation.school') }}</label>
                                    <select id='school_id' style='width:100%' name='school_id' class='form-control'>
                                        <option value='0'>
                                            {{ __('translation.school_id') }}
                                        </option>
                                        @foreach (\App\Models\school_types::get() as $school)
                                            {{-- @if ($type == 'credit') --}}
                                                <option value='{{ $school->id }}'>
                                                    {{ $school->school_name }}
                                                </option>
                                            {{-- @endif --}}
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="">
                                <div class="form-group">
                                    <label class='form-lable'> {{ __('translation.transaction_type') }}</label>
                                    <select id='owner' style='width:100%' name='transaction_type' class='form-control'>
                                        <option value='0'>
                                            {{ __('translation.all_types') }}
                                        </option>
                                        @foreach (\App\Models\SchoolTreasuryTransactionHistory::TYPES as $transaction_type => $type)
                                            @if ($type == 'debit')
                                                <option value='{{ $transaction_type }}'>
                                                    {{ __('translation.' . $transaction_type) }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">{{ __('translation.from_date') }}</label>
                                <input id='from_date' type="date" class="form-control form-control-solid" name=""
                                    id="" aria-describedby="helpId" placeholder="" />
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">{{ __('translation.to_date') }}</label>
                                <input id='to_date' type="date" class="form-control form-control-solid" name=""
                                    id="" aria-describedby="helpId" placeholder="" />
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
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
                        <div class="col-md-12 pt-5">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                    id="roles-table" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>{{ __('translation.transaction_id') }}</th>
                                            <th>{{ __('translation.trans_type') }}</th>
                                            <th>{{ __('translation.transaction_type') }}</th>
                                            <th>{{ __('translation.school') }}</th>
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
                            <button type="reset" id="kt_modal_add_customer_cancel"
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

    <script>
        let stauts, type = 'debit',
            transaction_type, from_date, to_date , school_id;
        let rolesTable = $('#roles-table').DataTable({
            dom: "tiplr",
            serverSide: true,
            processing: true,
            distroy: true,
            "language": {
                "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },
            ajax: {
                url: '{{ route('school.finincal.data') }}',
                data: function(q) {
                    q.type = type;
                    q.transaction_type = transaction_type;
                    q.from_date = from_date;
                    q.to_date = to_date;
                    q.school_id = school_id;
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
                    data: 'school_id',
                    name: 'school_id',
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
        $('#school_id').on('change', function() {
            school_id = $(this).val();
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
        $('#to_date').on('change', function() {
            to_date = $(this).val();
            rolesTable.ajax.reload();
        });
        $('input[name="amount"]').attr('type', 'number');
    </script>
@endpush
