@extends(auth()->guard('admin')->check() ?'layouts.admin.admin':'layouts.agents.agent_layouts')
@section('main-head')
{{__('translation.edit_section')}}
    <small> --- {{__('translation.Expenses_and_calculations')}}</small>
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
                        <form action="{{ route('Employee.section.update', $sections->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <x:text-input name='section_name' value='{{$sections->section_name}}' class='col-md-6' />
                                <div class="d-flex flex-column mb-3">
                                    <label class="fs-4 fw-bold mb-2">{{__('translation.description')}}</label>
                                    <textarea class="form-control form-control-solid" rows="1"   name="description" value='{{$sections->description}}'>{{$sections->description}}</textarea>
                                </div>
                                <div class='col-md-6'>
                                </div>
                                <div class="mt-4">
                                    <button  type="submit" class="btn btn-primary">
                                        {{__('translation.Save')}}
                                    </button>
                                    <a href='{{ route('Employee.section.index')}}' class="btn btn-outline-danger">
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
