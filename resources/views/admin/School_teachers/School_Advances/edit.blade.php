@extends('layouts.school.master')
@section('main-head')
    {{ __('translation.edit_teachers_Advances') }}
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
                        <form action="{{ route('School.Advances.update', $Advancess->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.school_id') }}
                                        </label>
                                        <select class="form-control form-control-solid" value="{{ old('school_id') }}" name="school_id" class="form-control" onclick="console.log($(this).val())"
                                        onchange="console.log('change is firing')">
                                            <option value="" selected disabled> {{ __('translation.Choose_school_id') }}
                                            </option>
                                            @foreach ($school_types  as $school_id)
                                                <option  value="{{ $school_id->id }}"  @if ($school_id->id == $Advancess->school_id ) selected  @endif>{{ $school_id->school_name }}
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
                                        <select class="form-control form-control-solid" name="teachers_id" class="form-control">
                                            <option selected disabled > {{ __('translation.Choose_teachers') }}
                                            </option>
                                            @foreach ($employees as $employes)
                                                <option value="{{ $employes->id }}" @if ($Advancess->teachers_id == $employes->id ) selected  @endif>{{ $employes->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('teachers_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.value') }}</label>
                                    <input type="number" class="form-control form-control-solid"
                                        placeholder="" step="0.01" value="{{$Advancess->advances_value}}" name="advances_value"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         />
                                        @error('advances_value')
                                            <span class="text-danger">
                                                {{$message}}
                                            </span>
                                        @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.month_number') }}</label>
                                        <select id='' class="form-control form-control-solid discounts" name='month_number'>
                                            <option selected disabled> {{ __('translation.chose_month_number') }}</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value='{{$i}}'  @if ($Advancess->month_number == $i) selected  @endif>
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
                                        <select id='' class="form-control form-control-solid discounts"
                                            name='year' readonly>
                                            @for ($year = date('Y') - 1; $year <= date('Y', strtotime('+5 year')); $year++)
                                                <option value='{{$year}}' @if ($Advancess->year == $year) selected  @endif>{{ $year }}</option>
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
                                    <a href='{{ route('School.Advances.index') }}' class="btn btn-outline-danger">
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
                    url: "{{ URL::to('teachers') }}/" + SectionId,
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
          
        });

    });

</script>
@endpush