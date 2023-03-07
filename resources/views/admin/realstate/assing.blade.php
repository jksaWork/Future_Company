{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head', __('translation.realstate_mangements'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <h3 style='font-size:20px'>{{ __('translation.assing_new_owner') }} </h3>
                </div>
                <!--begin::Card body-->
                <div class="card-body pt-0">

                    @include('layouts.includes.session')
                    <div class="row">
                        <form action='{{ route('realstate.assignOwnerToRalstate') }}' method='post'>
                            @csrf
                            <input type='hidden' name='type' value='rent' />
                            {{-- @dd($realstate) --}}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="form-group">
                                                <label for=""
                                                    style='font-size:20px'>{{ __('translation.realstate') }}</label>
                                                <select id='realstate' style='width:100%' name='realstate_id'
                                                {{!$realstate ?:'readonly'}}
                                                >
                                                    @if($realstate)
                                                    <option value='{{$realstate->id}}'> {{ $realstate->title }}</option>
                                                    @endif
                                                <option value='0'> {{ __('translation.chose_your_realstate') }}
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="">
                                            <div class="form-group">
                                                <label for=""
                                                    style='font-size:20px'>{{ __('translation.renter') }}</label>
                                                <select id='selUser' style='width:100%' name='owner_id'>
                                                    <option value='0'> {{ __('translation.chose_renter') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='pt-10'>
                                        <button class="btn btn-primary">
                                            {{ request()->type  == 'sale' ? __('translation.assing_saller'): __('translation.assing_renter') }}
                                        </button>
                                    </div>

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
        $(document).ready(function() {
            $('.js-example-disabled-results').select2();
            $("#selUser").select2({
                ajax: {
                    url: "{{ route('owners.ajax') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function(response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });
            $("#realstate").select2({
                ajax: {
                    url: "{{ route('realstate.ajax') }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        let term =  {
                            search: params.term,
                            type: 'rent' ,
                            is_rent: '1',
                        };
                        console.log(term, params);
                        return term;
                    },
                    processResults: function(response) {
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
