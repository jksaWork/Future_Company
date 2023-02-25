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
                        <form action="{{ route('Employee.Advances.update', $Advancess->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid"
                                    placeholder="" name="employee_id" value=" {{$Advancess->employee_id}}" required/>
                                    <input type="hidden" class="form-control form-control-solid"
                                    placeholder="" name="pro_id" value=" {{$Advancess->id}}" required/>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="" value=" {{ $Advancess->employee->name }}" required/>
                                        @error('employee_id')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.value') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                        placeholder="" step="0.01" value="{{$Advancess->advances_value}}" name="advances_value"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required />
                                        @error('advances_value')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label>{{__('translation.month')}}  :</label>
                                    <input type="date" id="advances_Date"class="form-control form-control-solid" name="advances_Date" value="{{$Advancess->advances_Date}}">
                                    {{-- <select class="form-control" name="advances_Date" value="{{$Advancess->advances_Date}}" class="form-control">
                                        <option value="January"> {{ __('translation.January') }}
                                        </option>
                                        <option value="February"> {{ __('translation.February') }}
                                        </option>
                                        <option value="March"> {{ __('translation.March') }}
                                        </option>
                                        <option value="April"> {{ __('translation.April') }}
                                        </option>
                                        <option value="May"> {{ __('translation.May') }}
                                        </option>
                                        <option value="June"> {{ __('translation.June') }}
                                        </option>
                                        <option value="July"> {{ __('translation.July') }}
                                        </option>
                                        <option value="August"> {{ __('translation.August') }}
                                        </option>
                                        <option value="September"> {{ __('translation.September') }}
                                        </option>
                                        <option value="October"> {{ __('translation.October') }}
                                        </option>
                                        <option value="November"> {{ __('translation.November') }}
                                        </option>
                                        <option value="December"> {{ __('translation.December') }}
                                        </option>

                                    </select> --}}
                                        @error('advances_Date')
                                            <span class="text-danger">
                                                {{$message}}
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
