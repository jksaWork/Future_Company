{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head' , __('translation.realstate_mangements') . '-' . __('translation.receipt_of_revenues') )
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <h3 style='font-size:20px'>{{__('translation.receipt_of_revenues')}} </h3>
            </div>
            <!--begin::Card body-->
            <div class="card-body pt-0">

                @include('layouts.includes.session')
                <div class="row">
                    <form action='{{route('realstate.Revenue')}}' method='post'>
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="">
                                        <div class="form-group">
                                          <label for="" style='font-size:20px'>{{__('translation.realstate')}}</label>
                                          <select id='realstate'  style='width:100%' name='realstate_id'
                                          {{!$realstate ?:'readonly'}}
                                          >
                                            @if($realstate)
                                            <option value='{{$realstate->id}}'> {{ $realstate->title }}</option>
                                            @endif
                                            <option value='0'> {{__('translation.chose_your_real_state')}}</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <div class="form-group">
                                          <label for="" style='font-size:20px'>{{__('translation.month_number')}}</label>
                                          <select id=''  style='width:100%' name='month_number'>
                                            <option value=''> {{__('translation.chose_month_number')}}</option>
                                            @for ($i = 1; $i < 13; $i++)
                                            <option value='{{$i}}'> {{$i . '  --   ' . date("F", mktime(null, null, null, $i, 1));}}</option>
                                            @endfor
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            <div class='pt-10'>
                            <button class="btn btn-primary">
                                {{__('translation.receipt_of_revenue')}}
                            </button></div>

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
