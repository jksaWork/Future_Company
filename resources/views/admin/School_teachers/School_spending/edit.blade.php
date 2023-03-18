@extends('layouts.school.master')
@section('main-head')
    {{ __('translation.edite_spending') }}
    <small> - {{ __('translation.School_expenses') }} </small>
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
                        <form action="{{ route('School.spending.update', $school_spendings->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid"
                                        placeholder="" name="pro_id" value='{{$school_spendings->id}}'/>
                                    <input type="text" class="form-control form-control-solid"
                                        placeholder="" name="spending_name" value='{{$school_spendings->spending_name}}'  />
                                        @error('spending_name')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label>{{__('translation.month')}}  :</label>
                                    <input class="form-control fc-datepicker form-control-solid" name="month" placeholder="YYYY-MM-DD"
                                    type="date" value="{{$school_spendings->month}}" >
                                        @error('advances_Date')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>






                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.school_name') }}
                                        </label>
                                        <select class="form-control form-control-solid" value="{{ old('school_id') }}" name="school_id" class="form-control" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')">
                                            <option value="" selected disabled> {{ __('translation.Choose_school_id') }}
                                            </option>
                                            @foreach ($school_types  as $school_id)
                                                <option  value="{{ $school_id->id }}"  @if ($school_id->id == $school_spendings->school_id ) selected  @endif>{{ $school_id->school_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('school_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.Category') }}
                                        </label>
                                        <select class="form-control form-control-solid" name="section_id" id="section_id"
                                            class="form-control" >

                                            @foreach ($school_sections as $section)
                                                <option value={{$section->id}}>{{ $section->section_name}}</option>
                                            @endforeach
                                        </select>
                                        @error("section_id")
                                        <span class="text-danger">
                                            {{$message}}
                                        </span>
                                    @enderror
                                    </div>
                                </div>
                                
                                <div class="fv-row mb-7 col-md-12 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.spending_value') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                        placeholder="" step="0.01" name="spending_value" value="{{$school_spendings->spending_value}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         />
                                        @error('spending_value')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                                </label>
                                <textarea class="form-control form-control-solid" rows="3" value="" name="description"
                                    placeholder="{{ __('translation.description') }}">{{$school_spendings->description}}</textarea>
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