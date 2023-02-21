{{-- @if (!) --}}
{{-- @dd('jksa');
@extends('layouts.admin.admin')
@else --}}
@extends(auth()->guard('admin')->check() ?'layouts.admin.admin':'layouts.agents.agent_layouts')
{{-- @endif --}}
@section('main-head')
    {{__('translation.realstate_mangements')}}
    <small> - {{__('translation.add_realstate')}} </small>
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
                        {{-- @include('layouts.includes.session') --}}
                        <form action="{{ route('realstate.realstate.update' , $realState->id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <x:text-input name='title' class='col-md-6' :value='$realState->title' />
                                <x:text-input name='realstate_number' class='col-md-6' :value='$realState->realstate_number' />
                                <x:text-input name='address' class='col-md-6' :value='$realState->address' />
                                <x:text-input name='price' class='col-md-6'  :value='$realState->price' :disabled='true' />

                                <x:select-options name='category_idd' :options='$categories'  :value='$realState->category_id' class='col-md-6' />
                                <x:select-options name='status' :options='["ready" , "inready"]'   :value='$realState->category_id' class='col-md-6' />
                                <x:text-area name='description' class='col-md-6' :value='$realState->description' />
                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        {{__('translation.save')}}
                                    </button>
                                    <a href='{{ route('owners.index')}}' class="btn btn-outline-danger">
                                        {{__('translation.cancel')}}
                                    </a>
                                </div>
                            </div>
                       </form>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Cadals-->
        </div>
        <!--end::Container-->
    </div>
@endsection
