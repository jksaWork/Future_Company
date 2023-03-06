{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head' , __('translation.realstate_mangements') . ' - ' . __('translation.show_opration_info') )
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <h3 style='font-size:20px'>{{__('translation.realstate_info')}} </h3>
            </div>
            <!--begin::Card body-->
            <div class="card-body pt-0">
                @include('layouts.includes.session')
                <div class="row">
                    <form action='{{route('realstate.assignOwnerToRalstate')}}' method='post' id='#revnues'>
                        @csrf
                        <div class="col-md-12">
                            <input type='hidden' value='{{$realstate->id}}' name='realstate_id'/>
                            <input type='hidden' name='verfied' value='true'/>
                            <input type='hidden' name='type' value='{{ $realstate->type }}'/>
                            <input type='hidden' name='owner_id' value='{{$owner->id}}' />
                        </div>
                        {{-- @dd($month_number , $realstate ,$realstate->CurrentOwner[0]->id) --}}
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle gs-0 gy-3">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fw-bolder text-muted bg-light">
                                        <th scope="row">
                                            <b>{{ __('translation.title') }}</b>
                                        </th>
                                        <td>{{ $realstate->title }}</td>
                                        <th scope="row">{{ __('translation.realstate_number') }}</th>
                                        <td>{{$realstate->realstate_number}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">{{ __('translation.address') }}</th>
                                        <td>{{$realstate->address }}</td>
                                        <th scope="row">{{ __('translation.price') }}</th>
                                        <td>{{$realstate->price }}</td>
                                    </tr>
                                    <tr class="fw-bolder text-muted bg-light">
                                            <th scope="row">{{ __('translation.category')}}</th>
                                            <td>{{ $realstate->Category->name ?? ''}}</td>
                                            <th scope="row">{{ __('translation.description') }}</th>
                                            <td>{{$realstate->description }}</td>
                                    </tr>
                                    <tr>
                                            <th scope="row">{{ __('translation.status') }}</th>
                                            <td>{!! $realstate->getStatusWithSpan() !!}</td>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->

                                <!--end::Table body-->
                            </table>
                        </div>

                        <div class="card-header border-0 pt-6">
                            <!--begin::Card title-->
                            {{-- @dd($realstate->type); --}}
                            <h3 style='font-size:20px'>{{$realstate->type == 'rent'?__('translation.owner_info'): (__('translation.owner_sale_info'))}} </h3>
                        </div>
                        <div class="pt-7">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                                <!--begin::Table head-->
                                @php
                                    $Owner = $owner;
                                @endphp
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase ">
                                        <th class="">{{ __('translation.name') }}</th>
                                        <th class="">{{ __('translation.email') }}</th>
                                        <th class="">{{ __('translation.phone') }}</th>
                                        <th class="">{{ __('translation.identification_type') }}</th>
                                        <th class="">{{ __('translation.identification_number') }}</th>
                                        <th class="">{{ __('translation.status') }}</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fw-bold text-gray-600">
                                    <tr>

                                        <td> {{ $Owner->name }}</td>
                                        <td> {{ $Owner->email }}</td>
                                        <td> {{ $Owner->phone }}</td>
                                        <td> {{ $Owner->identification_type }}</td>
                                        <td> {{ $Owner->identification_number }}</td>
                                        <td> {!! $Owner->getStatusWithSpan() !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-5">

                            <div class="px-2">
                                <a href='{{ route('realstate.assignOwner') }}'  class="btn btn-light-danger" type='reset'  >
                                    {{__('translation.cancel')}}
                                </a>
                                <button class="btn btn-primary">
                                    {{__('translation.assing_owner')}}
                                </button>
                            </div>
                        </div>
                    </form>
                    <!-- end of col -->
                </div><!-- end of row -->
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Container-->
</div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
$('.js-example-disabled-results').select2();
$( "#selUser" ).select2({
  ajax: {
    url: "{{route('owners.ajax')}}",
    type: "get",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        search: params.term // search term
      };
    },
    processResults: function (response) {
      return {
        results: response
      };
    },
    cache: true
  }

});
$( "#realstate" ).select2({
  ajax: {
    url: "{{route('realstate.ajax')}}",
    type: "get",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        search: params.term // search term
      };
    },
    processResults: function (response) {
      return {
        results: response
      };
    },
    cache: true
  }

});
});
</script>
@endpush
