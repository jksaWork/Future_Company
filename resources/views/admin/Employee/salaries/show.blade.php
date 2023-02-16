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
                <div class="card-body">




                    <div class="card card-xl-stretch mb-xl-8">
                        <!--begin::Header-->
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bolder fs-3 mb-1">Latest Orders</span>
                                <span class="text-muted mt-1 fw-bold fs-7">More than 100 new orders</span>
                            </h3>
                            <div class="card-toolbar">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary active fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_tab_1">Month</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_7_tab_2">Week</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light-primary fw-bolder px-4" data-bs-toggle="tab" href="#kt_table_widget_7_tab_3">Day</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body py-3">
                            <div class="tab-content">
                                <!--begin::Tap pane-->
                                <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle gs-0 gy-3">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="fw-bolder text-muted bg-light">
                                                    <th scope="row">{{trans('employeess_trans.name')}}</th>
                                                    <td>{{ $employees->name }}</td>
                                                    <th scope="row">{{trans('employeess_trans.email')}}</th>
                                                    <td>{{$employees->email}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{trans('employeess_trans.phone ')}}</th>
                                                    <td>{{$employees->phone }}</td>
                                                    <th scope="row">{{trans('employeess_trans.address')}}</th>
                                                    <td>{{$employees->address }}</td>
                                                </tr>
                                                <tr class="fw-bolder text-muted bg-light">
                                                        <th scope="row">{{trans('employeess_trans.salary ')}}</th>
                                                        <td>{{ $employees->salary}}</td>
                                                        <th scope="row">{{trans('employeess_trans.description ')}}</th>
                                                        <td>{{$employees->description }}</td>
                                                </tr>
                                                <tr>
                                                        <th scope="row">{{trans('employeess_trans.categories_id')}}</th>
                                                        <td>{{$employees->Categorys->categories_name }}</td>
                                                        <th scope="row">{{trans('employeess_trans.status')}}</th>
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
                                <!--begin::Tap pane-->
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
                                                               for="academic_year">{{__('translation.Attachments')}}
                                                               : <span class="text-danger"><p class="text-danger"> صيغة المرفق pdf, jpeg ,.jpg , png </p>*</span></label>
                                                           <input type="file" accept="image/*" name="photos[]" multiple required>
                                                           <input type="hidden" name="employees_name" value="{{$employees->name}}">
                                                           <input type="hidden" name="employees_id" value="{{$employees->id}}">
                                                       </div>
                                                   </div>


                                                   <br><br>
                                                   <button type="submit" class="button button-border x-small">
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
                                                   <th scope="col">{{__('translation.Processes')}}</th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                               @foreach($images as $attachment)
                                                   <tr style='text-align:center;vertical-align:middle'>
                                                       <td>{{$loop->iteration}}</td>
                                                       <td>{{$attachment->filename}}</td>
                                                       <td>{{$attachment->created_at->diffForHumans()}}</td>
                                                       <td colspan="2">
                                                           <a class="btn btn-outline-info btn-sm"
                                                              href="{{url('Employee/Download_attachment')}}/{{ $attachment->employee->name }}/{{$attachment->filename}}"
                                                              role="button"><i class="fas fa-download"></i>&nbsp; {{__('translation.Download')}}</a>

                                                           {{-- <button type="button" class="btn btn-outline-danger btn-sm"
                                                                   data-toggle="modal"
                                                                   data-target="#Delete_img{{ $attachment->id }}"
                                                                   title="{{ trans('Grades_trans.Delete') }}">{{__('translation.delete')}}
                                                           </button> --}}


                                                           <form action="{{ route('Employee.Delete_attachment') }}" id='delteForm' method="post" style="display: inline-block">
                                                            {{ csrf_field() }}
                                                            {{-- {{ method_field('DELETE') }} --}}

                                                            <input type="hidden" name="id" value="{{$attachment->id}}">

                                                            <input type="hidden" name="employees_name" value="{{$attachment->employee->name}}">
                                                            <input type="hidden" name="employees_id" value="{{$attachment->employee->id}}">
                                                            <input type="hidden" name="filename" readonly value="{{$attachment->filename}}" class="form-control">
                                                            <button type="submit" class="btn btn-danger  btn-sm" onclick="event.preventDefault();
                                                            DeleteApp('delteForm')"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                        </form><!-- end of form -->



                                                       </td>
                                                   </tr>
                                                   @include('admin.Employee.All_Employee.Delete_img')
                                               @endforeach
                                               </tbody>
                                           </table>
                                       </div>
                                   </div></div></div>
                                <!--end::Tap pane-->
                                <!--begin::Tap pane-->
                                <div class="tab-pane fade" id="kt_table_widget_7_tab_3" style="display: contents;">
                                    <!--begin::Table container-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table class="table align-middle gs-0 gy-3">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr>
                                                    <th class="p-0 w-50px"></th>
                                                    <th class="p-0 min-w-150px"></th>
                                                    <th class="p-0 min-w-140px"></th>
                                                    <th class="p-0 min-w-120px"></th>
                                                </tr>
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody>

                                            </tbody>
                                            <!--end::Table body-->
                                        </table>
                                    </div>
                                    <!--end::Table-->
                                </div>
                                <!--end::Tap pane-->
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>











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
