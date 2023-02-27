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
                                        name="name" value='{{ $employees->name }}' required />
                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.email') }}</label>
                                    <input type="email" class="form-control form-control-solid" placeholder=""
                                        name="email" value='{{ $employees->email }}' required />
                                    @error('email')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.phone') }}</label>
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="phone" value='{{ $employees->phone }}' required />
                                    @error('phone')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.address') }}</label>
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="address" value='{{ $employees->address }}' required />
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
                                        <select class="form-select form-select-solid is-valid form-control-solid"
                                            data-control="select2" name="data[]" data-allow-clear="true"
                                            multiple="multiple"
                                            style="display: block;width: 100%;padding: 0.75rem 1rem;font-size: 1.1rem;font-weight: 500;line-height: 1.5;color: #181C32;background-color: #ffffff;background-clip: padding-box;border: 1px solid #E4E6EF;appearance: none;border-radius: 0.475rem;box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;">
                                            {{-- @if (!$employee_allowances) --}}
                                            @foreach ($employee_allowances as $allowances)
                                                <option value="{{ $allowances->allowances_id }}"

                                                    @if ($allowances->employee_id == $employees->id) selected disabled @endif> {{-- disabled --}}
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
                                <div class='col-md-6'>
                                    <div class="form-group">
                                        <label for="" class="fs-6 fw-bold mb-2"> {{ __('translation.status') }}
                                        </label>
                                        <select class="form-control" name="status" id="status">

                                            <option value="1" @if ($employees->status == 1) selected @endif>
                                                {{ __('translation.active') }}
                                            </option>
                                            <option value="0" @if ($employees->status == 0) selected @endif>
                                                {{ __('translation.in_active') }}
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                            </label>
                            <textarea class="form-control form-control-solid" value='{{ $employees->description }}' rows="3"
                                name="description">{{ $employees->description }}</textarea>


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
