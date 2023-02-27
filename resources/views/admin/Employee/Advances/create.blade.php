@extends('layouts.admin.admin')
@section('main-head')
    {{ __('translation.Add_a_new_Advances') }}
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
                        <form action="{{ route('Employee.Advances.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid" placeholder=""
                                        name="employee_id" value=" {{ $employees->id }}" readonly />
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="" value=" {{ $employees->name }}" readonly />
                                    @error('employee_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.value') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        step="0.01" name="advances_value" value=""
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         />
                                    @error('advances_value')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.month_number') }}</label>
                                        <select id='' class="form-control" name='month_number'>
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

                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href='{{ route('Employee.All_Employee.index') }}' class="btn btn-outline-danger">
                                        Cancle
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
