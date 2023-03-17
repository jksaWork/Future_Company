@extends('layouts.school.master')
@section('main-head')
    {{ __('translation.add_employee_allowances') }}
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
                        <form action="{{ route('School.Teachers_allowances.store') }}" method="post">
                            @csrf
                            <div class="row">
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
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.name') }}
                                        </label>
                                        <select class="form-control form-control-solid" name="teachers_id" class="form-control" value="{{ old('employee_id') }}">
                                            <option value="" selected disabled> {{ __('translation.Choose_teachers') }}
                                            </option>
                                            {{-- @foreach ($employees as $employes)
                                                <option value="{{ $employes->id }}">{{ $employes->name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                        @error('employee_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.Category_allowances') }}
                                        </label> 
                                        <select class="form-control form-control-solid" name="allowances_id" class="form-control" value="{{ old('allowances_id') }}">
                                            <option value="" selected disabled> {{ __('translation.Choose_allowances') }}
                                            </option>
                                            {{-- @foreach ($allowances as $allowancess)
                                                <option value="{{ $allowancess->id }}">{{ $allowancess->allowances_name }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                        @error('allowances_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.month_number') }}</label>
                                        <select id='' class="form-control form-control-solid" name='month_number'>
                                            <option value="{{ old('month_number') }}"> {{ __('translation.chose_month_number') }}</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value='{{ $i }}'>
                                                    {{ $i . '  --   ' . date('F', mktime(null, null, null, $i, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                        @error('month_number')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.year') }}</label>
                                    <select id='' class="form-control form-control-solid discounts" value="{{ old('year') }}"
                                        name='year' readonly>
                                        @for ($year = date('Y') - 1; $year <= date('Y', strtotime('+5 year')); $year++)
                                            <option value='{{$year}}' >{{ $year }}</option>
                                        @endfor
                                    </select>
                                    @error('year')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    <div class="mt-4">
                        <button class="btn btn-primary">
                            {{ __('translation.Save') }}
                        </button>
                        <a href='{{ route('School.Teachers_allowances.index') }}' class="btn btn-outline-danger">
                            {{__('translation.Cancle')}}
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
                    url: "{{ URL::to('teachers_id') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    // console('sss'),
                    success: function(data) {
                        $('select[name="teachers_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="teachers_id"]').append('<option value="' +
                            key + '">' + value + '</option>');
                        });
                    },
                });

            } else {
                console.log('AJAX load did not work');
            }
            if (SectionId) {
                $.ajax({
                    url: "{{ URL::to('allowances_id') }}/" + SectionId,
                    type: "GET",
                    dataType: "json",
                    // console('sss'),
                    success: function(data) {
                        $('select[name="allowances_id"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="allowances_id"]').append('<option value="' + 
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