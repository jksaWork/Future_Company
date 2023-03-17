@extends('layouts.school.master')
@section('main-head')
    {{ __('translation.Edite_allowances_or_incentives') }}
    <small> - {{ __('translation.teachers_management') }} </small>
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
                        <form action="{{ route('School.allowances.update', $allowancess->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.school_id') }}
                                        </label>
                                        <select class="form-control form-control-solid" value="{{ old('school_id') }}" name="school_id" class="form-control">
                                            <option value="" selected disabled> {{ __('translation.Choose_school_id') }}
                                            </option>
                                            @foreach ($school_id as $school)
                                                <option  value="{{ $school->id }}"  @if ($school->id == $allowancess->school_id ) selected  @endif>{{ $school->school_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('school_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid"
                                        placeholder="" name="pro_id" value='{{$allowancess->id}}'/>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="allowances_name" value='{{$allowancess->allowances_name}}'  />
                                        @error('allowances_name')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>





                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.value') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                        placeholder="" step="0.01" name="allowances_value" value='{{$allowancess->allowances_value}}'  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         />
                                        @error('allowances_value')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                  <div class='col-md-6'>
                                        <div class="form-group">
                                            <label for="" class="fs-6 fw-bold mb-2"> {{ __('translation.status') }}
                                            </label>
                                            <select class="form-control" name="status" id="status">

                                                <option>
                                                   {{$allowancess-> getActive()}}
                                                </option>


                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        {{ __('translation.Save') }}
                                    </button>
                                    <a href='{{ route('School.allowances.index')}}' class="btn btn-outline-danger">
                                        {{__('translation.Cancle')}}
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
