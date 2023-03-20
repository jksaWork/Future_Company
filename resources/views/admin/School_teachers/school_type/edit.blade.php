@extends('layouts.school.master')
@section('main-head')
{{__('translation.edit_school')}}
    <small> --- {{__('translation.school_type')}}</small>
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
                        <form action="{{ route('School.school_type.update', $school_type->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <x:text-input name='school_name' value='{{$school_type->school_name}}' class='col-md-6' />
                                <div class="d-flex flex-column mb-3">
                                    <label class="fs-4 fw-bold mb-2">{{__('translation.description')}}</label>
                                    <textarea class="form-control form-control-solid" rows="1"   name="description" value='{{$school_type->description}}'>{{$school_type->description}}</textarea>
                                </div>
                                <div class='col-md-6'>
                                </div>
                                <div class="mt-4">
                                    <button  type="submit" class="btn btn-primary">
                                        {{__('translation.Save')}}
                                    </button>
                                    <a href='{{ route('School.school_type.index')}}' class="btn btn-outline-danger">
                                        {{__('translation.Cancle')}}
                                    </a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <!--end::Card body-->
            </div>
           
        </div>
        <!--end::Container-->
    </div>
@endsection
