@extends('layouts.admin.admin')
@section('main-head')
    {{ __('translation.edite_employee_allowances') }}
    <small> - {{ __('translation.employees') }} </small>
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
                        <form action="{{ route('Employee.employee_allowances.update', $employee_allowances->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.employees_name') }}
                                        </label>
                                        <select class="form-control form-control-solid" name="employee_id" class="form-control">
                                            <option value="" selected disabled> {{ __('translation.Choose_employee_id') }}
                                            </option>
                                            @foreach ($employees as $employes)
                                                <option value="{{ $employes->id }}" @if ($employee_allowances->employee_id === $employes->id) selected  @endif >
                                                    {{ $employes->name }}
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.Category') }}
                                        </label>
                                        <select class="form-control form-control-solid" name="allowances_id" class="form-control">
                                            <option value="" selected disabled> {{ __('translation.Choose') }}
                                            </option>
                                            @foreach ($allowances as $allowancess)
                                                <option value="{{ $allowancess->id }}" @if ($employee_allowances->allowances_id  == $allowancess->id) selected  @endif>{{ $allowancess->allowances_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('allowances_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.month_number') }}</label>
                                        <select id='' class="form-control form-control-solid" name='month_number'>
                                            <option value=''> {{ __('translation.chose_month_number') }}</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value='{{ $i }}'  @if ($employee_allowances->month_number  == $i) selected  @endif>
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.year') }}</label>
                                        <select id='' class="form-control form-control-solid discounts"
                                            name='year' readonly>
                                            @for ($year = date('Y') - 1; $year <= date('Y', strtotime('+5 year')); $year++)
                                                <option value='{{$year}}' @if ($employee_allowances->year == $year) selected  @endif>{{ $year }}</option>
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
                                    <a href='{{ route('Employee.All_Employee.index') }}' class="btn btn-outline-danger">
                                        {{ __('translation.Cancle') }}
                                    </a>
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
