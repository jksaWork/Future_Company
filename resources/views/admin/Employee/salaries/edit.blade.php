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
                                    <input type="hidden" class="form-control form-control-solid"
                                        placeholder="" name="pro_id" value='{{$employees->id}}'/>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="name" value='{{$employees->name}}'  required/>
                                        @error('name')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.email') }}</label>
                                    <input type="email" class="form-control form-control-solid"
                                        placeholder="" name="email" value='{{$employees->email}}'  required/>
                                        @error('email')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.phone') }}</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="phone" value='{{$employees->phone}}'  required/>
                                        @error('phone')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.address') }}</label>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="address" value='{{$employees->address}}'  required/>
                                        @error('address')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.salary') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                        placeholder="" step="0.01" name="salary" value='{{$employees->salary}}'  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        required />
                                        @error('salary')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.employees') }}
                                        </label>
                                        <select class="form-control" name="categories_id" id="categories_id"
                                            class="form-control" >

                                            @foreach ($Categorys as $Category)
                                                <option >{{$Category->categories_name}} </option>
                                            @endforeach
                                        </select>
                                        @error("employees")
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                                <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                                </label>
                                <textarea class="form-control form-control-solid" rows="1" name="description"
                                    placeholder="{{ __('translation.description') }}"></textarea>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.status') }}
                                            </label>
                                            <select class="form-control" name="status" id="status"
                                                class="form-control" checked>
                                                <option value="1" @if($employees ->status == '1')  @selected(true)@endif>  مفعل      </option>
                                                <option value="0" @if($employees ->status == '0')  @selected(true)@endif>  غير مفعل  </option>

                                            </select>
                                            @error("status")
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                        </div>
                                    </div>
                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href='{{ route('Employee.All_Employee.index')}}' class="btn btn-outline-danger">
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
