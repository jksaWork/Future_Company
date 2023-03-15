@extends('layouts.school.master')
@section('main-head', __('translation.show_students_renvue_details'))
@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <div class="card p-5">
                <div class="card-body p-3">
                    {{-- <h2>{{ __('translation.agent_details')}}</h2> --}}
                    {{-- <div class="card "> --}}
                        @include('layouts.includes.session')
                    <div class="card-header card-header-stretch">
                        <h3 class="card-title">{{ __('translation.show_students_renvue_details') }}</h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7">
                                        {{ __('translation.revnue_info') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_9">
                                        {{ __('translation.attachments') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                                <div>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase ">
                                                <th>{{ __('translation.id') }}</th>
                                            <th>{{ __('translation.student_name') }}</th>
                                            <th>{{ __('translation.student_guard') }}</th>
                                            <th>{{ __('translation.school_idd') }}</th>
                                            <th>{{ __('translation.amount') }}</th>
                                            <th>{{ __('translation.opration_type') }}</th>
                                            <th>{{ __('translation.opration_idd') }}</th>
                                            <th>{{ __('translation.revenue_type') }}</th>
                                            <th>{{ __('translation.recept_date') }}</th>
                                            {{-- <th>{{ __('translation.status') }}</th> جاهز ولا م جاهز --}}
                                            {{-- <th>@lang('translation.action')</th> --}}

                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-600">
                                            <tr>

                                                <td> {{ $studentRevenue->id }}</td>
                                                <td> {{ $studentRevenue->student_name }}</td>
                                                <td> {{ $studentRevenue->student_guard }}</td>
                                                <td> {{ $studentRevenue->School->school_name }}</td>
                                                <td> {{ $studentRevenue->amount }}</td>
                                                <td> {{ __('translation.' . $studentRevenue->opration_type) }}</td>
                                                <td> {{ $studentRevenue->opration_id }}</td>
                                                <td> {{ __('translation.' . $studentRevenue->revenue_type) }}</td>
                                                <td> {{ $studentRevenue->recept_date }}</td>
                                             </tr>
                                        </tbody>
                                    </table>
                                     </div>
                            </div>


                            <div class="tab-pane fade" id="kt_tab_pane_9" role="tabpanel">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                                    <!--begin::Table head-->
                                    <thead>
                                        <!--begin::Table row-->
                                        <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase ">
                                            <th class="">{{ __('translation.no') }}</th>
                                            <th class="">{{ __('translation.file') }}</th>
                                            <th class="">{{ __('translation.name') }}</th>
                                            <th class="">{{ __('translation.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($studentRevenue->attachments) > 0)
                                            @foreach ($studentRevenue->attachments as $attachment)
                                                <tr>
                                                    <td class=" "> {{ $attachment->id }}</td>
                                                    <td class=" "> <img
                                                            src="{{  $attachment->url }}"
                                                            width="80" alt=""></td>
                                                    <td class=" "> {{ $studentRevenue->name }}</td>
                                                    <td class=" ">
                                                        <div style="">
                                                            <a href="{{ route('show_attachments', $attachment->id) }}"
                                                                class="btn btn-light-primary btn-sm btn-icon">
                                                                <i class="fa fa-eye"></i>
                                                            </a>

                                                            <a href="{{ route('download_attachments', $attachment->id) }}"
                                                                class="btn btn-light-info btn-sm btn-icon">
                                                                <i class="fa fa-download"></i>
                                                            </a>


                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <div>
                                        <form action="{{ route('attachments.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name='type' value='renvue'>
                                            <input type="hidden" name="attachmentable" value='{{ $studentRevenue->id }}'>
                                            <x:input-file class="col-12" name='attachments[]' />
                                            <button class="btn btn-light-primary mt-3">{{ __('translation.Attach') }} </button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
