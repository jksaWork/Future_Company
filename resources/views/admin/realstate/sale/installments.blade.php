{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head' , __('translation.realstate_mangements') . '-' . __('translation.recept_installment_sidebar') )
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <!--begin::Container-->
    <div id="kt_content_container" class="container-xxl">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <h3 style='font-size:20px'>{{__('translation.recept_installment_sidebar')}} </h3>
            </div>
            <!--begin::Card body-->
            <div class="card-body pt-0">

                @include('layouts.includes.session')
                <div class="row">
                    <form action='{{route('realstate.receptInstallment')}}' method='post'>
                        @csrf
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="">
                                        <div class="form-group">
                                          <label for="" style='font-size:20px'>{{__('translation.realstate')}}</label>
                                          <select id='realstate'  style='width:100%' name='realstate_id'
                                          >
                                            <option value='0'> {{__('translation.chose_your_real_state')}}</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="">
                                        <div class="form-group">
                                          <label for="" style='font-size:20px'>{{__('translation.installment')}}</label>
                                          <select id='installment_id'  style='width:100%' name='installment_id'>
                                            <option value=''> {{__('translation.chose_installment')}}</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            <div class='pt-10'>
                            <button class="btn btn-primary">
                                {{__('translation.recept_installment')}}
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
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

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
    url: "{{route('realstate.ajax' , ['type' => 'sale'])}}",
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

$('#realstate').on('change' ,function(){
    let id = $(this).val();
    let url = "{{route('realstate.get_installment')}}" + `?id=${id}`;
    let options;
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json', // added data type
        success: function(res) {
            options = res.map(
                (el) =>{
                   let option  =  `<option value='${el.id}' ${(!el.is_payed ?null:'disabled')}>   نسبه القصد %${el.precentage} بقمه ${el.amount} </option>`;
                   $('#installment_id').append(option);
                })
                // console.log(options.toString())
                // $('installment_id').append(options.toString());
            } ,
        error:function (err){
            console.log('error');
        }});    // console.log(url);
});


</script>
@endpush
