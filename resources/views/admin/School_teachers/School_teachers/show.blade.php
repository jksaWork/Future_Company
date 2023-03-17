@extends('layouts.school.master')
@section('main-head')
    {{ __('translation.information') }}
    <small> - {{ $employees->name }} - </small>
@endsection
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-body pt-0">

                        <div class="py-5">
                            <div class="rounded border p-10">
                                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab"
                                            href="#kt_tab_pane_4">{{ __('translation.employee_information') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab"
                                            href="#kt_tab_pane_5">{{ __('translation.attachment') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab"
                                            href="#kt_tab_pane_6">{{ __('translation.allowances') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab"
                                            href="#kt_tab_pane_7">{{ __('translation.Advancess') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab"
                                            href="#kt_tab_pane_8">{{ __('translation.salaries') }}</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="kt_tab_pane_4" role="tabpanel">
                                        <table class="table align-middle gs-0 gy-3">
                                            <!--begin::Table head-->
                                            <thead>
                                                <tr class="fw-bolder text-muted bg-light">
                                                    <th scope="row">{{ __('translation.name') }}</th>
                                                    <td>{{ $employees->name }}</td>
                                                    <th scope="row">{{ __('translation.email') }}</th>
                                                    <td>{{ $employees->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">{{ __('translation.phone') }}</th>
                                                    <td>{{ $employees->phone }}</td>
                                                    <th scope="row">{{ __('translation.address') }}</th>
                                                    <td>{{ $employees->address }}</td>
                                                </tr>
                                                <tr class="fw-bolder text-muted bg-light">
                                                    <th scope="row">{{ __('translation.salary') }}</th>
                                                    <td><span class='badge badge-success'>{{ number_format($employees->salary, 2) }}</span></td>
                                                    <th scope="row">{{ __('translation.description') }}</th>
                                                    <td>{{ $employees->description }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"> {{ __('translation.Category') }}</th>
                                                    <td>{{ $employees->Categorys->categories_name }}</td>
                                                    <th scope="row">{{ __('translation.status') }}</th>
                                                    <td>{{ $employees->getActive() }}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"> {{ __('translation.allowances_id') }}</th>
                                                    <td>
                                                        @forelse ($employee_allowances as $index=>$allowanc)
                                                            {{ $allowanc->Allowances_id->allowances_name }} .
                                                            ({{ number_format($allowanc->Allowances_id->allowances_value, 2) }})<br>
                                                            @empty{{ __('translation.No_Data_Was_Found') }}
                                                        @endforelse
                                                    </td> 
                                                     <th scope="row">{{ __('translation.created_ats') }}</th>
                                                    <td>{{ $employees->month }}</td>
                                                    
                                                </tr>
                                                <tr><th scope="row">{{ __('translation.school_type') }}</th>
                                                    <td>{{ $employees->School->school_name }}</td></tr>
                                            </thead>

                                        </table>
                                    </div>
                                    <!--end::Table head-->
                                    <!--end::Table body-->

                                    <!--end::Table body-->




                                    {{-- being being being --}}

                                    <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">

                                        <form method="post" action="{{ route('School.Upload_attachment.store') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="academic_year">{{ __('translation.add_attachment') }}
                                                        : <span class="text-danger">
                                                            <p class="text-danger"> صيغة المرفق pdf, jpeg ,.jpg , png </p>*
                                                        </span></label>
                                                    <input type="file" accept="image/*" name="photos[]" multiple
                                                        required>
                                                    <input type="hidden" name="teachers_name"
                                                        value="{{ $employees->name }}">
                                                    <input type="hidden" name="teachers_id" value="{{ $employees->id }}">
                                                    <input type="hidden" name="school_id" value="{{ $employees->school_id }}">
                                                </div>
                                            </div>


                                            <br><br>
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('translation.submit') }}
                                            </button>
                                        </form>

                                        <br>
                                        <table class="table center-aligned-table mb-0 table table-hover"
                                            style="text-align:center">
                                            <thead>
                                                <tr class="table-secondary">
                                                    <th scope="col">#</th>
                                                    <th scope="col">{{ __('translation.filename') }}</th>
                                                    <th scope="col">{{ __('translation.created_at') }}</th>
                                                    <th scope="col">{{ __('translation.Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($images as $attachment)
                                                    <tr style='text-align:center;vertical-align:middle'>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $attachment->filename }}</td>
                                                        <td>{{ $attachment->created_at->diffForHumans() }}</td>
                                                        <td colspan="2">
                                                            <a class="btn btn-info btn-sm"
                                                                href="{{ url('School/Download_attachment') }}/{{ $attachment->teachers->name }}/{{ $attachment->filename }}"
                                                                role="button"><i class="fas fa-download"></i>&nbsp;
                                                                {{ __('translation.Download') }}</a>




                                                            <form action="{{ route('School.Delete_attachment') }}"
                                                                id='delteForm' method="post" style="display: inline-block">
                                                                {{ csrf_field() }}
                                                                {{-- {{ method_field('DELETE') }} --}}

                                                                <input type="hidden" name="id"
                                                                    value="{{ $attachment->id }}">

                                                                <input type="hidden" name="employees_name"
                                                                    value="{{ $attachment->teachers->name }}">
                                                                <input type="hidden" name="employees_id"
                                                                    value="{{ $attachment->teachers->id }}">
                                                                <input type="hidden" name="filename" readonly
                                                                    value="{{ $attachment->filename }}"
                                                                    class="form-control">
                                                                <button type="submit" class="btn btn-danger  btn-sm"
                                                                    onclick="event.preventDefault();
                                                         DeleteApp('delteForm')"><i
                                                                        class="fa fa-trash"></i>
                                                                    {{ __('translation.Delete') }}</button>
                                                            </form><!-- end of form -->



                                                        </td>
                                                    </tr>
                                                    @include('admin.School_teachers.School_teachers.Delete_img')
                                                @endforeach
                                            </tbody>
                                        </table>


                                    </div>


                                    {{-- end end end end --}}





                                    {{-- being being --}}
                                    <div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">


                                        <table class="table gs-7 gy-7 gx-7">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">

                                                    <th class="">#</th>
                                                    <th class="">{{ __('translation.employees_name') }}</th>
                                                    <th class="">{{ __('translation.allowances_name') }}</th>
                                                    <th class="">{{ __('translation.allowances_value') }}</th>
                                                    <th class=""> {{ __('translation.created_at') }}</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @forelse ($allowances_id as $index=>$employee)
                                                    <tr class="fw-bolder fs-6 text-gray-800">
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{!! $employee->employee->name !!}</td>
                                                        <td>{!! $employee->Allowances_id->allowances_name !!}</td>
                                                        <td><span class='badge badge-success'>{{ number_format($employee->Allowances_id->allowances_value, 2) }}</span>
                                                        </td>
                                                        <td>{!! $employee->created_at->format('d/M/Y') !!}</td>

                                                    </tr>
                                                @empty
                                                    <td colspan="4">
                                                        <div class="text-center">{{ __('translation.No_Data_Was_Found') }}</div>
                                                    </td>
                                                @endforelse
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>







                                    </div>
                                    {{-- end end end end  --}}





                                    <div class="tab-pane fade" id="kt_tab_pane_7" role="tabpanel">



                                        <table class="table gs-7 gy-7 gx-7">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">

                                                    <th class="">#</th>
                                                    <th class="">{{ __('translation.employee_name') }}</th>
                                                    <th class="">{{ __('translation.advances_value') }}</th>
                                                    <th class="">{{ __('translation.month_number') }}</th>
                                                    <th class="">{{ __('translation.created_at') }}</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @forelse ($Advances_id as $index=>$Advances)
                                                    <tr class="fw-bolder fs-6 text-gray-800">


                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{!! $Advances->employee->name !!}</td>
                                                        <td><span class='badge badge-success'>{!! number_format($Advances->advances_value, 2) !!}</span></td>
                                                        <td>{!! $Advances->month_number !!}</td>
                                                        <td>{!! $Advances->created_at->format('d/M/Y') !!}</td>

                                                    </tr>
                                                @empty
                                                    <td colspan="4">
                                                        <div class="text-center">{{ __('translation.No_Data_Was_Found') }}</div>
                                                    </td>
                                                @endforelse
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>


                                    </div>
                                    {{-- end end end  --}}




                                    <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">



                                        <table class="table gs-7 gy-7 gx-7">
                                            <!--begin::Table head-->
                                            <thead>
                                                <!--begin::Table row-->
                                                <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">

                                                    <th class="">#</th>
                                                    <th class="">{{ __('translation.employees_name') }}</th>
                                                    <th class="">{{ __('translation.fixed_salary') }}</th>
                                                    <th class="">{{ __('translation.allownacees_salary') }}</th>
                                                    <th class="">{{ __('translation.advances') }}</th>
                                                    <th class="">{{ __('translation.discounts') }}</th>
                                                    <th class="">{{ __('translation.totle_salaries') }}</th>
                                                    <th class="">{{ __('translation.month_number') }}</th>
                                                    <th class="">{{ __('translation.year') }}</th>
                                                    <th class=""> {{ __('translation.created_at') }}</th>
                                                    <th class="">{{ __('translation.status') }}</th>
                                                </tr>
                                                <!--end::Table row-->
                                            </thead>
                                            <!--end::Table head-->
                                            <!--begin::Table body-->
                                            <tbody class="fw-bold text-gray-600">
                                                @forelse ($salaries as $index=>$salaries)
                                                    <tr class="fw-bolder fs-6 text-gray-800">


                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{!! $salaries->employee->name !!}</td>
                                                        <td>{!! number_format($salaries->fixed_salary, 2) !!}</td>
                                                        <td>{!! number_format($salaries->allownacees_salary, 2) !!}</td>
                                                        <td>{!! number_format($salaries->advances, 2) !!}</td>
                                                        <td>{!! number_format($salaries->discounts, 2) !!}</td>
                                                        <td><span class='badge badge-warning'>{!! number_format($salaries->totle_salaries, 2) !!}</span></td>
                                                        <td>{!! $salaries->month_number !!}</td>
                                                        <td>{!! $salaries->year !!}</td>
                                                        <td>{!! $salaries->created_at->format('d/M/Y') !!}</td>
                                                        <td><span class='badge badge-success'>{!! $salaries->getActive() !!}</span></td>

                                                    </tr>
                                                @empty
                                                    <td colspan="4">
                                                        <div class="text-center">{{ __('translation.No_Data_Was_Found') }}</div>
                                                    </td>
                                                @endforelse
                                            </tbody>
                                            <!--end::Table body-->
                                        </table>


                                    </div>













                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Container-->
    </div>
@endsection
