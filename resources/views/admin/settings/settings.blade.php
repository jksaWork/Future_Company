
@extends('layouts.admin.admin')
@section('title' , __('translation.setting'))
@section('main-head', __('translation.setting'))
@section('content')



<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-xxl">
        <div class="card">
            <div class="card-header border-0 pt-6">

                <div class="card-body pt-0">
                <form method="post" action="{{ route('Employee.setting.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    {{--logo--}}


            <div class="row">




                <div class="col-lg-8">
                    <!--begin::Image input-->
                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image:url('{{ asset('uploads/' . setting('logo'))}}')">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px bgi-position-center" style="background-size: 75%; background-image:url({{ asset('uploads/' . setting('logo') )}})"></div>
                        <!--end::Preview existing avatar-->
                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="" data-bs-original-title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <!--begin::Inputs-->
                            <input type="file" name="logo" accept=".png, .jpg, .jpeg">

                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->
                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="" data-bs-original-title="Cancel avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Cancel-->
                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="" data-bs-original-title="Remove avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Remove-->
                    </div>
                    <!--end::Image input-->
                    <!--begin::Hint-->
                    <div class="form-text"> {{__('translation.pdf')}}.</div>
                    <!--end::Hint-->
                </div>
                <div class="form-group">
                    <label>{{__('translation.fav_icon')}}</label>
                    <input type="file" name="fav_icon" class="form-control load-image">
                    <img src="{{ asset('uploads/'. setting('fav_icon')) }}" class="loaded-image" alt="" style="display: {{ setting('fav_icon') ? 'block' : 'none' }}; width: 50px; margin: 10px 0;">
                </div>
                <div class="fv-row mb-7 col-md-12 ">
                    <label class=" fs-6 fw-bold mb-2">{{__('translation.title_name')}}</label>
                    <input type="text" class="form-control form-control-solid" name="title" value="{{ setting('title') }}"
                         />
                        @error('title')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                </div>

                <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                </label>
                <textarea class="form-control form-control-solid" rows="1"  name="description"
                    placeholder="{{ __('translation.description') }}">{{ setting('description') }}</textarea>

                <div class="fv-row mb-7 col-md-12 ">
                    <label class=" fs-6 fw-bold mb-2">{{__('translation.email')}}</label>
                    <input type="text" class="form-control form-control-solid" value="{{ setting('email') }}" name="email"/>

                        @error('email')
                            <span class="text-danger">
                                {{$message}}
                            </span>
                        @enderror
                </div>



                <div class="mt-4">
                    <button class="btn btn-primary">
                        {{ __('translation.Save') }}
                    </button>
                    <a href='{{ route('Employee.spending.index')}}' class="btn btn-outline-danger">
                        {{ __('translation.Cancle') }}
                    </a>
                </div>
            </div>
        </div><!-- end of tile -->
        </div><!-- end of col -->
    </div><!-- end of row -->
    </div>
@endsection
@push('scripts')
    <script>
        $(function(){
            $('input[name="logo"]').on('change' ,function(e){
                // alert('jksa');
                let that = $(this);
                reader = new FileReader();
                reader.onload = function(){
                    console.log(reader.result);
                    that.parent().find('.loaded-image').attr('src' , reader.result);
                    that.parent().find('.loaded-image').css('display' , 'block');
                }
                // console.log(e.target.files[0]);
                // that.parent().find('.loaded-image').attr('src' , e.target.files[0]);
                reader.readAsDataURL(e.target.files[0]);
                // that.parent().find('.loaded-image').attr('src' , e.target.files[0]);

                // reader.onlaod();
            });

            $('input[name="fav_icon"]').on('change' ,function(e){
                // alert('jksa');
                let that = $(this);
                reader = new FileReader();
                reader.onload = function(){
                    console.log(reader.result);
                    that.parent().find('.loaded-image').attr('src' , reader.result);
                    that.parent().find('.loaded-image').css('display' , 'block');
                }
                // console.log(e.target.files[0]);
                // that.parent().find('.loaded-image').attr('src' , e.target.files[0]);
                reader.readAsDataURL(e.target.files[0]);
                // that.parent().find('.loaded-image').attr('src' , e.target.files[0]);

                // reader.onlaod();
            });
        })
    </script>
@endpush
