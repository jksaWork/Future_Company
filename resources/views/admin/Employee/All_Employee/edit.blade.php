@extends('layouts.admin.admin')
@section('main-head')
    {{ __('translation.Add_a_new_employee') }}
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
                        <form action="{{ route('Employee.All_Employee.update', $employees->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid" placeholder=""
                                        name="pro_id" value='{{ $employees->id }}' />
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="name" value='{{ $employees->name }}'  />
                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.email') }}</label>
                                    <input type="email" class="form-control form-control-solid" placeholder=""
                                        name="email" value='{{ $employees->email }}'  />
                                    @error('email')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.phone') }}</label>
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="phone" value='{{ $employees->phone }}'  />
                                    @error('phone')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.address') }}</label>
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="address" value='{{ $employees->address }}'  />
                                    @error('address')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.salary') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        step="0.01" name="salary" value='{{ $employees->salary }}'
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required />
                                    @error('salary')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2">
                                            {{ __('translation.categories_id') }}
                                        </label>
                                        <select class="form-control form-control-solid" name="categories_id"
                                            id="categories_id" class="form-control">

                                            @foreach ($Categorys as $Category)
                                                <option>{{ $Category->categories_name }} </option>
                                            @endforeach
                                        </select>
                                        @error('categories_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2">
                                            {{ __('translation.allowances_id') }}
                                        </label>
                                        <select class="form-select form-select-solid " data-control="select2" name="data[]"   multiple="multiple">
                                            @foreach ($employee_allowances as $allowances)
                                                <option value="{{ $allowances->allowances_id }}"

                                                    @if ($allowances->employee_id == $employees->id) selected  @endif> {{-- disabled --}}
                                                    {{ $allowances->Allowances_id->allowances_name }} (
                                                    {{ $allowances->Allowances_id->allowances_value }}$)
                                                </option>
                                            @endforeach
                                            {{-- @endif --}}

                                            @foreach ($allowanceses as $allowan)


                                                        <option value="{{ $allowan->id }}">

                                                            {{ $allowan->allowances_name }} (
                                                            {{ $allowan->allowances_value }}$)


                                                        </option>

                                            @endforeach
                                        </select>
                                        @error('data')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label>{{__('translation.created_at')}}  :</label>
                                    <input class="form-control fc-datepicker form-control-solid" name="month" placeholder="YYYY-MM-DD"
                                    type="date" value="{{$employees->month}}" required>
                                        @error('advances_Date')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-12 ">
                            <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                            </label>
                            <textarea class="form-control form-control-solid" value='{{ $employees->description }}' rows="3"
                                name="description">{{ $employees->description }}</textarea>
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
