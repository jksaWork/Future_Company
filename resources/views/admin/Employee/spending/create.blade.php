@extends('layouts.admin.admin')
@section('main-head')
    {{ __('translation.Add_expenses') }}
    <small> - {{ __('translation.Expenses_and_calculations') }} </small>
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



                        <!--begin::Repeater-->
                        <div id="kt_docs_repeater_advanced">
                            <!--begin::Form group-->
                            <form action="{{ route('Employee.spending.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <div data-repeater-list="list_spending">
                                        <div data-repeater-item>
                                            <div class="form-group row mb-5">


                                                <div class="fv-row mb-7 col-md-6 ">
                                                    <label
                                                        class="form-label">{{ __('translation.Disbursement_departments') }}</label>
                                                    <select class="form-select" data-placeholder="Select an option"
                                                        name="section_id">
                                                        @foreach ($sections as $section)
                                                            <option value="{{ $section->id }}">{{ $section->section_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('section_id')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translation.name') }}</label>
                                                    <input type="text" name="spending_name"
                                                        class="form-control mb-2 mb-md-0" placeholder="Enter full name" />
                                                    @error('spending_name')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>


                                                <div class="fv-row mb-7 col-md-6 ">
                                                    <label class="form-label">{{ __('translation.spending_value') }}</label>
                                                    <input class="form-control form-control-solid" type="number"
                                                        step="1" name="spending_value" value=""
                                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                        required />
                                                    @error('spending_value')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">{{ __('translation.month') }}</label>
                                                    <input type="date" id="advances_Date"class="form-control form-control-solid" name="month" value="{{ date('Y-m-d') }}">

                                                    @error('month')
                                                        <span class="text-danger">
                                                            {{ $message }}
                                                        </span>
                                                    @enderror
                                                </div>


                                                <label for="" class=" fs-6 fw-bold mb-2">
                                                    {{ __('translation.description') }}
                                                </label>
                                                <textarea class="form-control form-control-solid" rows="1" name="description"
                                                    placeholder="{{ __('translation.description') }}"></textarea>
                                                <div class="col-md-2">
                                                    <a href="javascript:;" data-repeater-delete
                                                        class="btn btn-sm btn-light-danger mt-3 mt-md-9">
                                                        <i class="la la-trash-o fs-3"></i>Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Form group-->

                                <!--begin::Form group-->
                                <div class="form-group">

                                </div>
                                <div class="mt-4">
                                    <a href="javascript:;" data-repeater-create class="btn btn-success">
                                        <i class="la la-plus"></i>Add
                                    </a>
                                    <button class="btn btn-primary">
                                        Save
                                    </button>
                                    <a href='{{ route('Employee.spending.index') }}' class="btn btn-danger">
                                        Cancle
                                    </a>
                                </div>
                            </form>
                            <!--end::Form group-->
                        </div>

                    </div>



                </div>

            </div>
            <!--end::Card-->

        </div>
        <!--end::Container-->


    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>

    <script>
        $('#kt_docs_repeater_basic').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    </script>
@endpush
