@extends('layouts.admin.admin')
@section('main-head')
    {{ __('translation.Add_a_new_salary') }}
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
                        @include('layouts.includes.session')
                        <form action="{{ route('Employee.EmployeeSalaries') }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.employees_name') }}
                                        </label>
                                        <select class="form-control form-control-solid" name="employee_id" class="form-control">
                                            <option value="" selected disabled> {{ __('translation.Choose_employee_id') }}
                                            </option>
                                            @foreach ($employees as $employes)
                                                <option value="{{ $employes->id }}">{{ $employes->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('employee_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.month_number') }}</label>
                                        <select id='' class="form-control form-control-solid" name='month_number'>
                                            <option value=''> {{ __('translation.chose_month_number') }}</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value='{{ $i }}'>
                                                    {{ $i . '  --   ' . date('F', mktime(null, null, null, $i, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('month_number')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.year') }}</label>
                                    <select id='' class="form-control form-control-solid discounts"
                                        name='year' readonly>
                                        @for ($year = date('Y'); $year <= date('Y', strtotime('+5 year')); $year++)
                                            <option>{{ $year }}</option>
                                        @endfor
                                    </select>
                                    @error('year')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        {{ __('translation.Save') }}
                                    </button>
                                    <a href='{{ route('Employee.salaries.index') }}' class="btn btn-outline-danger">
                                        {{ __('translation.Cancle') }}
                                    </a>
                                </div>
                            </div>

                    </div>
                    </form>




                </div>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->

    </div>
    <!--end::Container-->
    </div>
@endsection
