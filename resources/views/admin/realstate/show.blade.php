@extends('layouts.admin.admin')
@section('main-head', __('translation.show_real_state_detalis'))
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
                        <h3 class="card-title">{{ __('translation.realstate_information') }}</h3>
                        <div class="card-toolbar">
                            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#kt_tab_pane_7">
                                        {{ __('translation.realstate_information') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab"
                                        href="#kt_tab_pane_8">{{ __('translation.realstate_owner_info') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_9">
                                        {{ __('translation.realstate_attachment') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                                <div>
                                    <div class="tab-pane fade show active" id="kt_table_widget_7_tab_1">
                                        <!--begin::Table container-->
                                        <div class="table-responsive">
                                            <!--begin::Table-->
                                            <table class="table align-middle gs-0 gy-3">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <tr class="fw-bolder text-muted bg-light">
                                                        <th scope="row">
                                                            <b>{{ __('translation.title') }}</b>
                                                        </th>
                                                        <td>{{ $realState->title }}</td>
                                                        <th scope="row">{{ __('translation.realstate_number') }}</th>
                                                        <td>{{$realState->realstate_number}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">{{ __('translation.address') }}</th>
                                                        <td>{{$realState->address }}</td>
                                                        <th scope="row">{{ __('translation.price') }}</th>
                                                        <td>{{$realState->price }}</td>
                                                    </tr>
                                                    <tr class="fw-bolder text-muted bg-light">
                                                            <th scope="row">{{ __('translation.category')}}</th>
                                                            <td>{{ $realState->Category->name ?? ''}}</td>
                                                            <th scope="row">{{ __('translation.description') }}</th>
                                                            <td>{{$realState->description }}</td>
                                                    </tr>
                                                    <tr>
                                                            <th scope="row">{{ __('translation.status') }}</th>
                                                            <td>{!! $realState->getStatusWithSpan() !!}</td>
                                                    </tr>
                                                </thead>
                                                <!--end::Table head-->
                                                <!--begin::Table body-->

                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                        <!--end::Table-->
                                    </div>
                                 </div>
                            </div>
                            <div class="tab-pane fade" id="kt_tab_pane_8" role="tabpanel">
                                <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
                                    <x:rent-real-state-owner :realstates='$realState->Owners' :realstate='$realState'  />
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
                                        @if (count($realState->attachments) > 0)
                                            @foreach ($realState->attachments as $attachment)
                                                <tr>
                                                    <td class=" "> {{ $attachment->id }}</td>
                                                    <td class=" "> <img
                                                            src="{{  $attachment->url }}"
                                                            width="80" alt=""></td>
                                                    <td class=" "> {{ $realState->title }}</td>
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

                                                            {{-- <a href="{{ route('agent.show', ['status' => true , 'agent' => $attachment->id]) }}" class="btn btn-light-success btn-sm btn-icon">
                                                            <i class="fa fa-toggle-on"></i>
                                                             </a> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <div>
                                        <form action="{{ route('attachments.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name='type' value='realstate'>
                                            <input type="hidden" name="attachmentable" value='{{ $realState->id }}'>
                                            <x:input-file class="col-12" name='attachments[]' />
                                            <button class="btn btn-light-primary mt-3">{{__('translation.Attach')}} </button>
                                        </form>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

