@extends(auth()->guard('admin')->check() ?'layouts.school.master':'layouts.agents.agent_layouts')
@section('main-head')
{{__('translation.edit_section')}}
    <small> --- {{__('translation.School_expenses')}}</small>
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
                        <form action="{{ route('School.section.update', $school_sections->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.school_name') }}
                                        </label>
                                        <select class="form-control form-control-solid" value="{{ old('school_id') }}" name="school_id" class="form-control">
                                            <option value="" selected disabled> {{ __('translation.Choose_school_id') }}
                                            </option>
                                            @foreach ($school_id as $school)
                                                <option  value="{{ $school->id }}"  @if ($school->id == $school_sections->school_id ) selected  @endif>{{ $school->school_name }}
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
                                <x:text-input name='section_name' value='{{$school_sections->section_name}}' class='col-md-6' />
                                <div class="d-flex flex-column mb-3">
                                    <label class="fs-4 fw-bold mb-2">{{__('translation.description')}}</label>
                                    <textarea class="form-control form-control-solid" rows="1"   name="description" value='{{$school_sections->description}}'>{{$school_sections->description}}</textarea>
                                </div>
                                <div class='col-md-6'>
                                </div>
                                <div class="mt-4">
                                    <button  type="submit" class="btn btn-primary">
                                        {{__('translation.Save')}}
                                    </button>
                                    <a href='{{ route('School.section.index')}}' class="btn btn-outline-danger">
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
