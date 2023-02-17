@extends('layouts.admin.admin')
@section('main-head')
    {{ __('translation.Add_a_new_salary') }}
    <small> - {{ __('translation.employees_management') }} </small>
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
<form>
    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">{{__('translation.salary_history')}}</label>
                            <input class="form-control flatpickr-input" data-kt-repeater="datepicker" name="month" value="{{ date('Y-m-d') }}" placeholder="Pick a date" type="date" readonly="readonly" required>
                            @error('month')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                        </div>
                        <div class="col-md-6" style="text-align: center;padding: 27px;">

                            <button class="btn btn-primary">
                                Save
                            </button>


                        </div></div>
</form>


                        <form action="{{ route('Employee.salaries.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid"
                                    placeholder="" name="employee_id" value=" {{$employees->id}}" required/>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="" value=" {{ $employees->name }}" required/>
                                        @error('employee_id')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.fixed_salary') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                        placeholder="" step="0.01" name="fixed_salary" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required />
                                        @error('salary')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.allownacees_salary') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                    placeholder="" step="0.01" name="allownacees_salary" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required />
                                        @error('allownacees_salary')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.advances') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                    placeholder="" step="0.01" name="advances" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required />
                                        @error('advances')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.totle_salaries') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                    placeholder="" step="0.01" name="totle_salaries" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required />
                                        @error('totle_salaries')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.discounts') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                    placeholder="" step="0.01" name="discounts" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                    required />
                                        @error('discounts')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{__('translation.salary_history')}}</label>
                                    <input class="form-control flatpickr-input" data-kt-repeater="datepicker" name="month" value="{{ date('Y-m-d') }}" placeholder="Pick a date" type="date" readonly="readonly" required>
                                    @error('month')
                                    <span class="text-danger">
                                        {{$message}}
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
                                    <button class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href='{{ route('Employee.salaries.index')}}' class="btn btn-outline-danger">
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
