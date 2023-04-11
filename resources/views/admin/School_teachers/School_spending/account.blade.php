@extends('layouts.school.master')
@section('main-head')
    {{ __('translation.Add_a_new_amount') }}
    <small> -- {{$school_spendings->spending_name}} -- </small>
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
                        <form action="{{ route('School.account.store') }}" method="post">
                            @csrf
                            <div class="row">
                               
                                <div class="fv-row mb-7 col-md-6 ">
                                    <input type="hidden" class="form-control form-control-solid"
                                        placeholder="" name="pro_id" value='{{$school_spendings->id}}'/>
                                
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <input type="hidden" class="form-control form-control-solid"
                                        placeholder="" name="status" value='1'/>
                                
                                </div>

                                
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.value') }}</label>
                                    <input type="number" class="form-control form-control-solid" value="{{ old('value') }}"
                                        placeholder="" step="0.01" name="value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         />
                                        @error('value')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label>{{__('translation.date')}}  :</label>
                                    <input class="form-control form-control-solid" name="month" value="{{ date('Y-m-d') }}"
                                    type="date"  value="{{ old('month') }}" >
                                        @error('month')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                                </label>
                                <textarea class="form-control form-control-solid" rows="3"  name="description" value="{{ old('description') }}"
                                    placeholder="{{ __('translation.description') }}"></textarea>
                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        {{ __('translation.Save') }}
                                    </button>
                                    <a href='{{ route('School.spending.index')}}' class="btn btn-outline-danger">
                                        {{ __('translation.Cancle') }}
                                    </a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->

        </div>
        <!--end::Container-->
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('select[name="school_id"]').on('change', function() {
            var SectionId = $(this).val();
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('section') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    // console('sss'),
                    success: function(data) {
                        $('select[name="section_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="section_id"]').append('<option value="' +
                            key + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
        });

    });

</script>
@endpush