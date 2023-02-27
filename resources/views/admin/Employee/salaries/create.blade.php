@extends('layouts.admin.admin')
@section('main-head')
    {{ __('translation.Add_a_new_salary') }}
    <small> - {{ $employees->name }} </small>
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
                        <form action="{{ route('Employee.salaries.index') }}">

                            <div class="row">


{{--
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.month_being') }}
                                        </label>

                                        <input type="date" id="advances_Date"class="form-control form-control-solid" name="month" value="{{ date('Y-m-d') }}">

                                        @error('month')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.month_end') }}
                                        </label>

                                        <input type="date" id="advances_Date"class="form-control form-control-solid" name="end_month" value="{{ date('Y-m-d') }}">

                                        @error('end_month')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid" placeholder=""
                                        name="employee_id" value=" {{ $employees->id }}" required />
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="" value=" {{ $employees->name }}" required />
                                    @error('employee_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                 <div class="col-md-6">
                                        <div class="form-group">
                                          <label class=" fs-6 fw-bold mb-2">{{__('translation.month_number')}}</label>
                                          <select class="form-control  form-control-solid" name='month_number'>
                                            <option value=''> {{__('translation.chose_month_number')}}</option>
                                            @for ($i = 1; $i < 13; $i++)
                                            <option value='{{$i}}'> {{$i . '  --   ' . date("F", mktime(null, null, null, $i, 1));}}</option>
                                            @endfor
                                        </select>
                                        </div>
                                    </div>

                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href='{{ route('Employee.salaries.index') }}' class="btn btn-outline-danger">
                                        Cancle
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
