@extends(
    auth()->guard('admin')->check()
        ? 'layouts.admin.admin'
        : 'layouts.agents.agent_layouts'
)
@section('main-head', __('translation.employees'))
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
                            <form action="{{ route('Employee.All_Employee.index') }}" method="get">
                                <input type="text" name='search' value="{{ request()->search }}"
                                    class="form-control form-control-solid w-250px ps-15" placeholder="Search Area" />

                            </form>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">

                            <!--begin::Menu 1-->

                            <!--end::Menu 1-->
                            <!--end::Filter-->
                            <!--begin::Export-->

                            <!--end::Export-->
                            <!--begin::Add customer-->
                            <a href='{{ route('Employee.All_Employee.create') }}'
                                class="btn btn-primary">{{ __('translation.Add') }}</a>
                            <!--end::Add customer-->
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
                    <table class="table gs-7 gy-7 gx-7" id="kt_customers_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_customers_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-125px">#</th>
                                <th class="">{{ __('translation.name') }}</th>
                                <th class="">{{ __('translation.phone') }}</th>
                                <th class="">{{ __('translation.salary') }}</th>
                                <th class="">{{ __('translation.categories_id') }}</th>
                                <th class="">{{ __('translation.allowances_id') }}</th>
                                <th class="">{{ __('translation.status') }}</th>
                                <th class="text-end min-w-70px">{{ __('translation.Actions') }}</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            @forelse ($employees as $index=>$employee)
                                <tr class="fw-bolder fs-6 text-gray-800">

                                    <td>
                                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="{{ $employee->id }}" />

                                        </div>
                                    </td>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->salary }}</td>
                                    <td>{!! $employee->Categorys->categories_name !!}</td>

                                    <td>@forelse ($allowns as $allowances){!! $allowances->Allowances_id->allowances_name !!}- @empty
                                       No Data Was Found
                                    @endforelse</td>

                                    <td>{!! $employee->getActive() !!}</td>
                                    {{-- <td></td> --}}

                                    <td class=" text-end">
                                        <a href="#"
                                            class="btn btn-light btn-active-light-primary btn-sm show menu-dropdown"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                            data-kt-menu-flip="top-end">
                                            {{ __('translation.Actions') }}
                                            <span class="svg-icon svg-icon-5 m-0">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px"
                                                    viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                        <path
                                                            d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                            fill="#000000" fill-rule="nonzero"
                                                            transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4 show"
                                            data-kt-menu="true"
                                            style="z-index: 105; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-79px, 392px, 0px);"
                                            data-popper-placement="bottom-end">

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('Employee.All_Employee.show', $employee->id) }}"
                                                    class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                                    {{ __('translation.show_employee_information') }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('Employee.employee_allowances.show', $employee->id) }}"
                                                    class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                                    {{ __('translation.employee_allowances') }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->

                                             <!--begin::Menu item-->
                                             <div class="menu-item px-3">
                                                <a href="{{ route('Employee.Advances.show', $employee->id) }}"
                                                    class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                                    {{ __('translation.Advances') }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                              <!--begin::Menu item-->
                                              <div class="menu-item px-3">
                                                <a href="{{ route('Employee.salaries.show', $employee->id) }}"
                                                    class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                                    {{ __('translation.add_salaries') }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->

                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('Employee.All_Employee.edit', $employee->id) }}"
                                                    class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                                                    {{ __('translation.edit') }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->


                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <form action="{{ route('Employee.All_Employee.destroy', $employee->id) }}"
                                                    method="post" id='{{ 'owner_delete_from_' . $employee->id }}'>
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#"
                                                        onclick="document.getElementById('owner_delete_from_{{ $employee->id }}').submit()"
                                                        class="menu-link px-3 bg-light-danger "
                                                        data-kt-menu-trigger="click">{{ __('translation.Delete') }}
                                                    </a>
                                                </form>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                    <!--end::Menu-->
                                    {{-- </td> --}}
                                </tr>
                            @empty
                                <td colspan="4">
                                    <div class="text-center">No Data Was Found</div>
                                </td>
                            @endforelse
                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Container-->
    </div>


    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function DeleteApp(val) {
            console.log();
            Swal.fire({
                title: " @lang('هل أنت واثق؟')",
                text: " @lang('لن تتمكن من التراجع عن هذا!')",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: " @lang('نعم ، احذفها!')",
                cancelButtonText: " @lang('إلغاء')"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        " @lang('تم الحذف')",
                        " @lang('تم حذف ملفك.')",
                        " @lang('النجاح')"
                    );
                    document.getElementById(val).submit();
                }
            });
        }
    </script>
@endsection
