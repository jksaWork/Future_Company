@extends(auth()->guard('admin')->check() ?'layouts.admin.admin':'layouts.agents.agent_layouts')
@section('main-head')
{{__('translation.edit_Categoires')}}
    <small> - {{__('translation.employees_management')}}</small>
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
                        <form action="{{ route('Employee.categories.update' , $categorys->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <x:text-input name='categories_name' value='{{$categorys->categories_name}}' class='col-md-6' />
                                <div class="d-flex flex-column mb-3">
                                    <label class="fs-4 fw-bold mb-2">{{__('translation.description')}}</label>
                                    <textarea cols="30" rows="10" class="form-control form-control-solid" name="description" value='{{$categorys->description}}'  >{{$categorys->description}}</textarea>
                                </div>
                                <div class='col-md-6'>
                                </div>
                                <div class="mt-4">
                                    <button  type="submit" class="btn btn-primary">
                                        {{__('translation.Save')}}
                                    </button>
                                    <a href='{{ route('Employee.categories.index')}}' class="btn btn-outline-danger">
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

            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
@endsection
