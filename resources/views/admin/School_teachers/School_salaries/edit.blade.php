{{-- @if (!) --}}
{{-- @dd('jksa');
@extends('layouts.school.master')
@else --}}
@extends(auth()->guard('admin')->check() ?'layouts.school.master':'layouts.agents.agent_layouts')
{{-- @endif --}}
@section('main-head')
    {{__('translation.edite_salariesss')}}
    <small> - {{ $salaries->teachers->name }}</small>
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
                        <form action="{{ route('School.salaries.update', $salaries->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.school_id') }}
                                        </label>
                                        <select class="form-control form-control-solid" value="{{ old('school_id') }}" name="school_id" class="form-control">
                                           
                                                <option  value="{{$salaries->school_id }}">{{ $salaries->School->school_name }}
                                                </option>
                                           
                                        </select>
                                        @error('school_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid" placeholder=""
                                        name="teachers_id" value="{{$salaries->teachers_id}}" required />
                                    <input type="text" class="form-control form-control-solid" placeholder=""
                                        value=" {{$salaries->teachers->name}}" readonly />
                                    @error('teachers_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.fixed_salary') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                    step="1" min="0" name="fixed_salary" value="{{ $salaries->fixed_salary }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        readonly />
                                    @error('salary')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.allowancess_fixed') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                    step="1" min="0" name="allowancess_fixed" value="{{ $salaries->allowancess_fixed}}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        readonly />
                                    @error('allowancess_fixed')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.advances') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                    step="1" min="0" name="advances" value="{{$salaries->advances}}" readonly/>
                                    @error('advances')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.totle_salaries') }}</label>
                                    <input type="number" class="form-control form-control-solid totle_salaries" placeholder=""
                                    step="1" min="0" id="totle_salaries" name="totle_salaries"
                                        value="{{$salaries->totle_salaries}}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        readonly />
                                    @error('totle_salaries')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.discounts') }}</label>
                                    <input type="number" class="form-control form-control-solid discounts" placeholder=""
                                        step="1" min="0"  name="discounts" id="discounts"  value="{{$salaries->discounts}}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         onchange="Discounts()" />
                                    @error('discounts')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                                </label>
                                <textarea class="form-control form-control-solid" rows="3" name="discrption"  value="{{$salaries->discrption}}"
                                    >{{$salaries->discrption}}</textarea>
                                <div class="mt-4">

                                    <button class="btn btn-primary">
                                        {{ __('translation.Save') }}
                                    </button>
                                    <a href='{{ route('School.salaries.index') }}' class="btn btn-outline-danger">
                                        {{__('translation.Cancle')}}
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
        </div>
        <!--end::Container-->
    </div>
@endsection

@push('scripts')

<script>


    function Discounts() {


        var totle_salaries = parseFloat(document.getElementById("totle_salaries").value);
        var advances = parseFloat(document.querySelector('input[name="advances"]').value);
        var fixed_salary = parseFloat(document.querySelector('input[name="fixed_salary"]').value);
        var allowancess_fixed = parseFloat(document.querySelector('input[name="allowancess_fixed"]').value);
        var discounts = parseFloat(document.getElementById("discounts").value);


        var capital_totle =  fixed_salary + allowancess_fixed - advances - discounts;
        if ( capital_totle < 0) {

            alert('قيمة الخصم اكبر من مجموع الراتب');

        } else {
            document.getElementById("totle_salaries").value = capital_totle;

        }
    }
</script>
@endpush
