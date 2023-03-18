@extends('layouts.school.master')
@section('main-head')
    {{ __('translation.Add_a_new_School') }}
    <small> - {{ __('translation.teachers_management') }} </small>
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
                        <form action="{{ route('School.All_Teachers.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="name"  value="{{ old('name') }}" />
                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.email') }}</label>
                                    <input type="email" class="form-control form-control-solid" placeholder=""
                                        name="email"  value="{{ old('email') }}" />
                                    @error('email')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.phone') }}</label>
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="phone"  value="{{ old('phone') }}" />
                                    @error('phone')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.address') }}</label>
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        name="address"  value="{{ old('address') }}"  />
                                    @error('address')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.salary') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        step="0.01" name="salary" value="{{ old('salary') }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         />
                                    @error('salary')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.school_id') }}
                                        </label>
                                        <select class="form-control form-control-solid" value="{{ old('school_id') }}" name="school_id" class="form-control" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')">
                                            <option value="" selected disabled> {{ __('translation.Choose_school_id') }}
                                            </option>
                                            @foreach ($school_id as $school_id)
                                                <option  value="{{ $school_id->id }}">{{ $school_id->school_name }}
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
                                        <select class="form-control" name="categories_id" id="categories_id"
                                        value="{{ old('categories_id') }}" >
                                            <option  selected disabled> {{ __('translation.Choose') }}
                                            </option>
                                            {{-- @foreach ($Category as $categoryres)
                                                <option  value="{{ $categoryres->id }}">{{ $categoryres->categories_name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                        @error('categories_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.allowances_id') }}
                                        </label>
                                        {{-- <select  class="form-select form-select-solid is-valid"   data-control="select2"  data-allow-clear="true" multiple="multiple"  style="display: block;width: 100%;padding: 0.75rem 1rem;font-size: 1.1rem;font-weight: 500;line-height: 1.5;color: #181C32;background-color: #ffffff;background-clip: padding-box;border: 1px solid #E4E6EF;appearance: none;border-radius: 0.475rem;box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;"> --}}
                                            <select class="form-select form-select-solid " data-control="select2" name="data[]"   multiple="multiple">

                                                
                                            {{-- <option  selected disabled> --{{ __('translation.Choose_allowances') }}--
                                            </option> --}}
                                            {{-- @foreach ($allowances as $allowances_id)
                                            <option value="{{ $allowances_id->id}}">{{ $allowances_id->allowances_name }} ( {{ $allowances_id->allowances_value }}$)
                                            </option>
                                        @endforeach --}}
                                        </select>
                                        @error('data')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="fv-row mb-7 col-md-6 ">
                                    <label>{{__('translation.created_ats')}}  :</label>
                                    <input class="form-control fc-datepicker" name="month" value="{{ date('Y-m-d') }}"
                                    type="date"  value="{{ old('month') }}" >
                                        @error('month')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>
                                <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                                </label>
                                <textarea class="form-control form-control-solid" rows="3" name="description" value="{{ old('description') }}"
                                    placeholder="{{ __('translation.description') }}"></textarea>
                                <div class="mt-4">
                                    <button class="btn btn-primary">
                                        {{ __('translation.Save') }}
                                    </button>
                                    <a href='{{ route('School.All_Teachers.index') }}' class="btn btn-outline-danger">
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
                    url: "{{ URL::to('School_teachers') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    // console('sss'),
                    success: function(data) {
                        $('select[name="categories_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="categories_id"]').append('<option value="' +
                            key + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('allowances') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    // console('sss'),
                    success: function(data) {
                        $('select[name="data[]"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="data[]"]').append('<option value="' +
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