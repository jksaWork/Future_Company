{{-- @if (!) --}}
{{-- @dd('jksa');
@extends('layouts.admin.admin')
@else --}}
@extends(auth()->guard('admin')->check() ?'layouts.admin.admin':'layouts.agents.agent_layouts')
{{-- @endif --}}
@section('main-head')
    {{__('translation.edite_salariesss')}}
    <small> - {{ $salaries->employee->name }}</small>
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
                        {{-- @include('layouts.includes.session') --}}
                        <form action="{{ route('Employee.salaries.update', $salaries->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.name') }}</label>
                                    <input type="hidden" class="form-control form-control-solid" placeholder=""
                                        name="employee_id" value="{{$salaries->employee_id}}" required />
                                    <input type="text" class="form-control form-control-solid" placeholder="" name=""
                                        value=" {{$salaries->employee->name}}" readonly />
                                    @error('employee_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.fixed_salary') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        step="0.01" name="fixed_salary" value="{{ $salaries->fixed_salary }}"
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
                                       step="0.01" name="allowancess_fixed" value="{{ $salaries->allowancess_fixed}}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        readonly />
                                    @error('allowancess_fixed')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.allownacees_salary') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        step="0.01" name="allownacees_salary" value="{{$salaries->allownacees_salary}}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                        readonly />
                                    @error('allownacees_salary')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.advances') }}</label>
                                    <input type="number" class="form-control form-control-solid" placeholder=""
                                        step="0.01" name="advances" value="{{$salaries->advances}}"/>
                                    @error('advances')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="fv-row mb-7 col-md-6 ">
                                    <label class=" fs-6 fw-bold mb-2">{{ __('translation.totle_salaries') }}</label>
                                    <input type="number" class="form-control form-control-solid totle_salaries" placeholder=""
                                        step="0.01" id="totle_salaries" name="totle_salaries"
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
                                        step="1" min="0" name="discounts" value="0" id="discounts"  value="{{$salaries->discounts}}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                         onchange="Discounts()" />
                                    @error('discounts')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class=" fs-6 fw-bold mb-2">{{ __('translation.salary_history') }}</label>
                                        <select id='' class="form-control form-control-solid discounts" name='month_number'>

                                            <option value='{{$salaries->month_number}}'> {{$salaries->month_number . '  --   ' . date('F', mktime(null, null, null,$salaries->month_number , 1)) }}</option>

                                        </select>
                                        @error('month_number')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                </div>
                                <div class='col-md-6'>
                                    {{-- <x:status-filed name='status'  value="{{$salaries->status}}"/> --}}
                                        <div class="form-group">
                                            <label for="" class="fs-6 fw-bold mb-2"> {{__('translation.status')}} </label>
                                            <select class="form-control" name="status"  >
                                                <option value="1" @if($salaries ->status == '1')  selected @endif>{{__('translation.active')}}</option>
                                                <option value="0" @if($salaries ->status == '0')  selected @endif>{{__('translation.in_active')}}</option>
                                            </select>
                                        </div>
                                </div>
                                <label for="" class=" fs-6 fw-bold mb-2"> {{ __('translation.description') }}
                                </label>
                                <textarea class="form-control form-control-solid" rows="1" name="discrption"  value="{{$salaries->discrption}}"
                                    placeholder="{{ __('translation.description') }}"></textarea>
                                <div class="mt-4">

                                    <button class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href='{{ route('Employee.salaries.index') }}' class="btn btn-outline-danger">
                                        Cancle
                                    </a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            <!--begin::Modals-->
            <!--begin::Modal - Customers - Add-->

            <!--end::Modal - New Card-->
            <!--end::Modals-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@push('scripts')

<script>


    function Discounts() {


        var totle_salaries = parseFloat(document.getElementById("totle_salaries").value);
        var advances = parseFloat(document.querySelector('input[name="advances"]').value);
        var allownacees_salary = parseFloat(document.querySelector('input[name="allownacees_salary"]').value);
        var fixed_salary = parseFloat(document.querySelector('input[name="fixed_salary"]').value);
        var allowancess_fixed = parseFloat(document.querySelector('input[name="allowancess_fixed"]').value);
        var discounts = parseFloat(document.getElementById("discounts").value);


        var capital_totle = allownacees_salary + fixed_salary + allowancess_fixed - advances - discounts;
        if (typeof totle_salaries === 'undefined') {

            alert('يرجى التاكد من  البيانات ');

        } else {
            document.getElementById("totle_salaries").value = capital_totle;

        }
    }
</script>
@endpush
