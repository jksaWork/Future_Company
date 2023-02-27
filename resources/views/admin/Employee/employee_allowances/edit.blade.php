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
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid" value="{{$employee_allowances->id}}"
                                    placeholder="" name="pro_id"  readonly/>
                                    <input type="hidden" class="form-control form-control-solid" value="{{$employee_allowances->employee_id}}"
                                    placeholder="" name="employee_id"  readonly/>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="" value=" {{$employee_allowances->employee->name}}" readonly/>
                                        @error('employee_id')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.month_number') }}</label>
                                        <select id='' class="form-control" name='month'>
                                            <option value=''> {{ __('translation.chose_month_number') }}</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value='{{ $i }}'>
                                                    {{ $i . '  --   ' . date('F', mktime(null, null, null, $i, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('month')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
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
