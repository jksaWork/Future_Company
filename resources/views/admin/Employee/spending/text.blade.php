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
                <div class="card-body">




                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">{{ __('translation.employee_information') }}</span>
                            </h3>
                            <div class="card-toolbar">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_tab_1">{{ __('translation.employee_information') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_tab_2">{{ __('translation.attachment') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_tab_3">{{ __('translation.employee_allowances') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_tab_4">{{ __('translation.Advancess') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                            <div class="tab-content">
                                <!--begin::Tap 1 pane-->
                                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle gs-0 gy-3">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="fw-bolder text-muted bg-light">
                                                    <th scope="row">{{ __('translation.name') }}</th>
                                                    <td>{{ $employees->name }}</td>
                                                    <th scope="row">{{ __('translation.email') }}</th>
                                                    <td>{{$employees->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{ __('translation.phone') }}</th>
                                                    <td>{{$employees->phone }}</td>
                                                    <th scope="row">{{ __('translation.address') }}</th>
                                                    <td>{{$employees->address }}</td>
                                                </tr>
                                                <tr class="fw-bolder text-muted bg-light">
                                                        <th scope="row">{{ __('translation.salary')}}</th>
                                                        <td>{{ $employees->salary}}</td>
                                                        <th scope="row">{{ __('translation.description') }}</th>
                                                        <td>{{$employees->description }}</td>
                                                </tr>
                                                <tr>
                                                        <th scope="row"> {{ __('translation.Category') }}</th>
                                                        <td>{{$employees->Categorys->categories_name }}</td>
                                                        <th scope="row">{{ __('translation.status') }}</th>
                                                        <td>{{ $employees->getActive() }}</td>
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->

                                            <!--end::Table body-->
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Tap pane-->
                                <!--begin::Tap2 pane-->
                                <div class="tab-pane fade" id="kt_table_widget_7_tab_2">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <div class="tab-pane fade" id="profile-02" role="tabpanel"
                                        aria-labelledby="profile-02-tab" style="display: contents;">
                                       <div class="card card-statistics">
                                           <div class="card-body">
                                               <form method="post" action="{{route('Employee.Upload_attachment.store')}}" enctype="multipart/form-data">
                                                   {{ csrf_field() }}
                                                   <div class="col-md-3">
                                                       <div class="form-group">
                                                           <label
                                                               for="academic_year">{{__('translation.add_attachment')}}
                                                               : <span class="text-danger"><p class="text-danger"> صيغة المرفق pdf, jpeg ,.jpg , png </p>*</span></label>
                                                           <input type="file" accept="image/*" name="photos[]" multiple required>
                                                           <input type="hidden" name="employees_name" value="{{$employees->name}}">
                                                           <input type="hidden" name="employees_id" value="{{$employees->id}}">
                                                       </div>
                                                   </div>


                                                   <br><br>
                                                   <button type="submit" class="btn btn-primary">
                                                          {{__('translation.submit')}}
                                                   </button>
                                               </form>
                                           </div>
                                           <br>
                                           <table class="table center-aligned-table mb-0 table table-hover"
                                                  style="text-align:center">
                                               <thead>
                                               <tr class="table-secondary">
                                                   <th scope="col">#</th>
                                                   <th scope="col">{{__('translation.filename')}}</th>
                                                   <th scope="col">{{__('translation.created_at')}}</th>
                                                   <th scope="col">{{__('translation.Actions')}}</th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                               @foreach($images as $attachment)
                                                   <tr style='text-align:center;vertical-align:middle'>
                                                       <td>{{$loop->iteration}}</td>
                                                       <td>{{$attachment->filename}}</td>
                                                       <td>{{$attachment->created_at->diffForHumans()}}</td>
                                                       <td colspan="2">
                                                           <a class="btn btn-info btn-sm"
                                                              href="{{url('Employee/Download_attachment')}}/{{ $attachment->employee->name }}/{{$attachment->filename}}"
                                                              role="button"><i class="fas fa-download"></i>&nbsp; {{__('translation.Download')}}</a>




                                                           <form action="{{ route('Employee.Delete_attachment') }}" id='delteForm' method="post" style="display: inline-block">
                                                            {{ csrf_field() }}
                                                            {{-- {{ method_field('DELETE') }} --}}

                                                            <input type="hidden" name="id" value="{{$attachment->id}}">

                                                            <input type="hidden" name="employees_name" value="{{$attachment->employee->name}}">
                                                            <input type="hidden" name="employees_id" value="{{$attachment->employee->id}}">
                                                            <input type="hidden" name="filename" readonly value="{{$attachment->filename}}" class="form-control">
                                                            <button type="submit" class="btn btn-danger  btn-sm" onclick="event.preventDefault();
                                                            DeleteApp('delteForm')"><i class="fa fa-trash"></i> {{ __('translation.Delete') }}</button>
                                                        </form><!-- end of form -->



                                                       </td>
                                                   </tr>
                                                   @include('admin.Employee.All_Employee.Delete_img')
                                               @endforeach
                                               </tbody>
                                           </table>
                                       </div>
                                   </div></div>
                                <!--end::Tap pane-->
                                <!--begin::Tap 3 pane-->
                                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_3">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
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
                                                    <th class="">{{ __('translation.employee_name') }}</th>
                                                    <th class="">{{ __('translation.allowances_name') }}</th>
                                                    <th class="text-end min-w-70px"> {{ __('translation.date') }}</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @forelse ($allowances_id as $index=>$employee)
                                                    <tr class="fw-bolder fs-6 text-gray-800">

                                                        <td>
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                                {{-- <input class="form-check-input" type="checkbox" value="{{ $employee->id}}" /> --}}

                                                            </div>
                                                        </td>
                                                        <td>{{$index + 1 }}</td>
                                                        <td>{!!$employee->employee->name!!}</td>
                                                        <td>{!!$employee->Allowances_id->allowances_name!!}</td>
                                                        <td>{!!$employee->created_at->format('d/M/Y')!!}</td>

                                                    </tr>
                                                @empty
                                                    <td colspan="4">
                                                        <div class="text-center">No Data Was Found</div>
                                                    </td>
                                                @endforelse
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Tap 4 pane-->
                                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_4">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
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
                                                    <th class="">{{ __('translation.employee_name') }}</th>
                                                    <th class="">{{ __('translation.advances_value') }}</th>
                                                    <th class="">{{ __('translation.advances_Date') }}</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @forelse ($Advances_id as $index=>$Advances)
                                                    <tr class="fw-bolder fs-6 text-gray-800">

                                                        <td>
                                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                                {{-- <input class="form-check-input" type="checkbox" value="{{ $employee->id}}" /> --}}

                                                            </div>
                                                        </td>
                                                        <td>{{$index + 1 }}</td>
                                                        <td>{!!$Advances->employee->name!!}</td>
                                                        <td>{!! number_format($Advances->advances_value, 2)!!}</td>
                                                        <td>{!!$Advances->advances_Date!!}</td>

                                                    </tr>
                                                @empty
                                                    <td colspan="4">
                                                        <div class="text-center">No Data Was Found</div>
                                                    </td>
                                                @endforelse
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->

                    </div></div></div></div>









                <!--end::Card body-->



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
