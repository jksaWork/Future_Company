@extends('layouts.admin.admin')
@section('content')
    <div>
        <h2>@lang('settings.settings')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
        <li class="breadcrumb-item">@lang('settings.general_settings')</li>
    </ul> <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                {{-- <div class="card-header border-0 pt-6"> --}}
                    <!--begin::Card title-->
                    {{-- <h3 style='font-size:20px'>{{ __('translation.assing_new_owner') }} </h3> --}}
                {{-- </div> --}}
                <!--begin::Card body-->
                {{-- <div class="card-body pt-0"> --}}

                    {{-- @include('layouts.includes.session') --}}
    <div class="row">
        {{-- <div class="col-md-12">
            <div class="tile ">
                <form method="post" action="{{ route('admin.setting.store') }}" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    logo
                    <div class="form-group">
                        <label>@lang('settings.logo')</label>
                        <input type="file" name="logo" class="form-control load-image">
                        <img src="{{ Storage::url('uploads/' . setting('logo')) }}" class="loaded-image" alt="" style="display: {{ setting('logo') ? 'block' : 'none' }}; width: 100px; margin: 10px 0;">
                    </div>
                    fav_icon
                    <div class="form-group">
                        <label>@lang('settings.fav_icon')</label>
                        <input type="file" name="fav_icon" class="form-control load-image">
                        <img src="{{ Storage::url('uploads/' . setting('fav_icon')) }}" class="loaded-image" alt="" style="display: {{ setting('fav_icon') ? 'block' : 'none' }}; width: 50px; margin: 10px 0;">
                    </div>
                    title
                    <div class="form-group">
                        <label>@lang('settings.title')</label>
                        <input type="text" name="title" class="form-control" value="{{ setting('title') }}">
                    </div>
                    description
                    <div class="form-group">
                        <label>@lang('settings.description')</label>
                        <textarea name="description" class="form-control">{{ setting('description') }}</textarea>
                    </div>
                    keywords
                    <div class="form-group">
                        <label>@lang('settings.keywords')</label>
                        <input type="text" name="keywords" class="form-control" value="{{ setting('keywords') }}">
                    </div>

                    email
                    <div class="form-group">
                        <label>@lang('users.email')</label>
                        <input type="text" name="email" class="form-control" value="{{ setting('email') }}">
                    </div>
                    submit
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.update')</button>
                    </div>
                </form><!-- end of form -->
            </div><!-- end of tile -->
        </div><!-- end of col --> --}}


        
    </div><!-- end of row -->
                
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
