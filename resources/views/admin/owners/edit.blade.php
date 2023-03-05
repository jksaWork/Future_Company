{{-- @extends('layouts.admin.admin') --}}
@extends(auth()->guard('admin')->check() ?'layouts.admin.admin':'layouts.agents.agent_layouts')

@section('main-head')
    Owner Mangement
    <small> - Edit Owner </small>
@endsection
{{-- @section('head') --}}
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
                        <form action="{{ route('owners.update', $owner->id)}}" method="post" >
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <x:text-input name='name' class='col-md-6'  value='{{$owner->name}}'/>
                                <x:text-input name='email' class='col-md-6'  value='{{$owner->email}}' />
                                <x:text-input name='phone' class='col-md-6'  value='{{$owner->phone}}'/>
                                {{-- <x:text-input name='phone' class='col-md-6' /> --}}
                                @php
                                    $Identification_type= ['national_number','national_card','passport'];
                                @endphp
                                <x:select-options name='identification_type' :options='$Identification_type'
                                :value='$owner->Identification_type'
                                class='col-md-6' />
                                {{-- @dd($owner->identification_number); --}}
                                <x:text-input  class='col-md-6' name='identification_number' value='{{$owner->identification_number}}'  />
                                <div class='col-md-6'>
                                    <x:status-filed />
                                </div>
                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href='{{ route('owners.index')}}' class="btn btn-outline-danger">
                                        Cancle
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
