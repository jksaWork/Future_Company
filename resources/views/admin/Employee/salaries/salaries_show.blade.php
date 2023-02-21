@extends(
    auth()->guard('admin')->check()
        ? 'layouts.admin.admin'
        : 'layouts.agents.agent_layouts'
)
@section('main-head', __('translation.Add_a_new_salary') )
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
                        <div class="d-flex align-items-center py-1">
                            <div class="modal fade" id="kt_modal_upgrade_plan" tabindex="-1" aria-hidden="true">
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-xl">
                                    <!--begin::Modal content-->
                                    <div class="modal-content rounded">
                                        <!--begin::Modal header-->
                                        <div class="modal-header justify-content-end border-0 pb-0">
                                            <!--begin::Close-->
                                            <div class="btn btn-sm btn-icon btn-active-color-primary"
                                                data-bs-dismiss="modal">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16"
                                                            height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                                            fill="black" />
                                                        <rect x="7.41422" y="6" width="16" height="2"
                                                            rx="1" transform="rotate(45 7.41422 6)"
                                                            fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
                                        <!--begin::Modal body-->
                                        <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
                                            <!--begin::Heading-->
                                            <div class="mb-13 text-center">
                                                <h1 class="mb-3">
                                                    {{ __('translation.Lists_to_clarify_allowances_and_advances') }}</h1>

                                            </div>
                                            <!--end::Heading-->
                                            <!--begin::Plans-->
                                            <div class="d-flex flex-column">

                                                <!--begin::Row-->
                                                <div class="row mt-10">
                                                    <!--begin::Col-->
                                                    <div class="col-lg-6 mb-10 mb-lg-0">
                                                        <!--begin::Tabs-->
                                                        <div class="nav flex-column">

                                                            <h1 class="mb-3">{{ __('translation.Advancess') }}</h1>
                                                            <!--begin::Tab link-->
                                                            <table class="table table-hover" id="kt_customers_table">
                                                                <!--begin::Table head-->
                                                                <thead>
                                                                    <!--begin::Table row-->
                                                                    <tr
                                                                        class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">

                                                                        <th class="">
                                                                            {{ __('translation.employee_name') }}</th>
                                                                        <th class="">
                                                                            {{ __('translation.advances_value') }}</th>
                                                                        <th class="">
                                                                            {{ __('translation.advances_Date') }}</th>
                                                                        <th class="">{{ __('translation.month') }}
                                                                        </th>
                                                                    </tr>
                                                                    <!--end::Table row-->
                                                                </thead>
                                                                <!--end::Table head-->
                                                                <!--begin::Table body-->
                                                                <tbody class="fw-bold text-gray-600">
                                                                    <?php $sum_advances_value = 0; ?>
                                                                    @forelse ($employee_advances as $index=>$Advancess)
                                                                        <tr class="fw-bolder fs-6 text-gray-800">


                                                                            <td>{!! $Advancess->employee->name !!}</td>
                                                                            <td>{!! number_format($Advancess->advances_value, 2) !!}</td>
                                                                            <td>{!! $Advancess->advances_Date !!}</td>
                                                                            <td>{!! $Advancess->created_at->toFormattedDateString() !!}</td>
                                                                            {{-- <td></td> --}}


                                                                            <!--end::Menu-->
                                                                            {{-- </td> --}}
                                                                        </tr>
                                                                        <?php $sum_advances_value += $Advancess->advances_value; ?>
                                                                    @empty
                                                                        <td colspan="4">
                                                                            <div class="text-center">No Data Was Found</div>
                                                                        </td>
                                                                    @endforelse
                                                                    <tr>
                                                                        <td colspan="1">المجموع:</td>

                                                                        <td class="pt-6 text-dark fw-boldest">
                                                                            {{ number_format($sum_advances_value, 2) }}</td>

                                                                    </tr>
                                                                </tbody>
                                                                <!--end::Table body-->
                                                            </table>
                                                            <!--end::Tab link-->
                                                        </div>
                                                        <!--end::Tabs-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-6">
                                                        <!--begin::Tab Pane-->
                                                        <h1 class="mb-3">{{ __('translation.employee_allowances') }}</h1>
                                                        <table class="table table-hover" id="kt_customers_table">
                                                            <!--begin::Table head-->
                                                            <thead>
                                                                <!--begin::Table row-->
                                                                <tr
                                                                    class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">

                                                                    <th class="">{{ __('translation.employee_name') }} </th>
                                                                    <th class="">{{ __('translation.value') }}</th>
                                                                    <th class="">{{ __('translation.allowances_name') }}</th>
                                                                    <th class="">{{ __('translation.date') }}</th>
                                                                    <th class="">{{ __('translation.month') }}</th>
                                                                </tr>
                                                                <!--end::Table row-->
                                                            </thead>
                                                            <!--end::Table head-->
                                                            <!--begin::Table body-->
                                                            <tbody class="fw-bold text-gray-600">
                                                                <?php $sum_allowances_value = 0; ?>
                                                                @forelse ($employee_allowancess as $index=>$employee_allowancess)
                                                                    <tr class="fw-bolder fs-6 text-gray-800">


                                                                        <td>{!!$employee_allowancess->employee->name !!}</td>
                                                                        <td>{!!number_format($employee_allowancess->allowances->allowances_value, 2) !!}</td>
                                                                        <td>{!!$employee_allowancess->allowances->allowances_name !!}</td>
                                                                        <td>{!!$employee_allowancess->month !!}</td>
                                                                        <td>{!!$employee_allowancess->created_at->toFormattedDateString() !!}</td>
                                                                    </tr>
                                                                    <?php $sum_allowances_value += $employee_allowancess->allowances->allowances_value; ?>
                                                                @empty
                                                                    <td colspan="4">
                                                                        <div class="text-center">No Data Was Found</div>
                                                                    </td>
                                                                @endforelse
                                                                <tr>
                                                                    <td colspan="1">المجموع:</td>

                                                                    <td class="pt-6 text-dark fw-boldest">
                                                                        {{ number_format($sum_allowances_value, 2) }}</td>

                                                                </tr>
                                                            </tbody>
                                                            <!--end::Table body-->
                                                        </table>
                                                        <!--end::Tab Pane-->

                                                        <!--end::Tab content-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <!--end::Row-->
                                            </div>
                                            <!--end::Plans-->
                                            <!--begin::Actions-->

                                            <!--end::Actions-->
                                        </div>
                                        <!--end::Modal body-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                        </div>
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->

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
                    <!--begin::Col-->
                    <form action="{{ route('Employee.salaries.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="fv-row mb-7 col-md-6 ">
                                <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                <input type="hidden" class="form-control form-control-solid" placeholder=""
                                    name="employee_id" value="{{ $employees->id }}" required />
                                <input type="text" class="form-control form-control-solid" placeholder=""
                                    value="{{ $employees->name }}" readonly />
                                @error('employee_id')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7 col-md-6 ">
                                <label class=" fs-6 fw-bold mb-2">{{ __('translation.fixed_salary') }}</label>
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    step="0.01" name="fixed_salary" value="{{ $employees->salary }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    readonly />
                                @error('salary')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7 col-md-6 ">
                                <label class=" fs-6 fw-bold mb-2">{{ __('translation.allownacees_salary') }}</label>
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    step="0.01" name="allownacees_salary" value="{{ $sum_allowances_value }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    readonly />
                                @error('allownacees_salary')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7 col-md-6 ">
                                <label class=" fs-6 fw-bold mb-2">{{ __('translation.advances') }}</label>
                                <input type="number" class="form-control form-control-solid" placeholder=""
                                    step="0.01" name="advances" value="{{ $sum_advances_value }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    readonly />
                                @error('advances')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7 col-md-6 ">
                                <label class=" fs-6 fw-bold mb-2">{{ __('translation.totle_salaries') }}</label>
                                <input type="number" class="form-control form-control-solid totle_salaries" placeholder=""
                                    step="0.01" id="totle_salaries" name="totle_salaries"
                                    value="{{ $employees->salary + $sum_allowances_value - $sum_advances_value }}"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    readonly />
                                @error('totle_salaries')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7 col-md-6 ">
                                <label class=" fs-6 fw-bold mb-2">{{ __('translation.discounts') }}</label>
                                <input type="number" class="form-control form-control-solid discounts" placeholder=""
                                    step="1" min="0" name="discounts" value="0" id="discounts"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required onchange="Discounts()" />
                                @error('discounts')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ __('translation.salary_history') }}</label>
                                <input type="date" id="advances_Date"class="form-control form-control-solid" name="month" value="{{ date('Y-m-d') }}">
                                @error('month')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>







                            <div class='col-md-6'>
                                <x:status-filed name='status' />
                            </div>
                            <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                            </label>
                            <textarea class="form-control form-control-solid" rows="1" name="discrption"
                                placeholder="{{ __('translation.description') }}"></textarea>
                            <div class="mt-4">
                                <a href="#" class="btn btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_upgrade_plan">{{ __('translation.information') }}</a>
                                <button class="btn btn-primary">
                                    Save
                                </button>
                                <a href='{{ route('Employee.salaries.index') }}' class="btn btn-outline-danger">
                                    Cancle
                                </a>
                            </div>
                        </div>

                    </form>
                    <!--end::Col-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Container-->
    </div>








    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script>


        function Discounts() {


            var totle_salaries = parseFloat(document.getElementById("totle_salaries").value);
            var discounts = parseFloat(document.getElementById("discounts").value);


            var capital_totle = totle_salaries - discounts;
            // console.log(capital_totle);
            if (typeof totle_salaries === 'undefined') {

                alert('يرجى التاكد من  البيانات ');

            } else {
                document.getElementById("totle_salaries").value = capital_totle;

            }
        }
    </script>
@endsection
