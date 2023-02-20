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
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_9">
                                        {{ __('translation.realstate_attachment') }}</a>
                                </li>
                                @if($realState->type == 'rent')
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab"
                                        href="#kt_tab_pane_8">{{ __('translation.realstate_owner_info') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_11">
                                        {{ __('translation.realstate_revenues') }}</a>
                                </li>
                                @elseif ($realState->type == 'sale')
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab"
                                        href="#kt_tab_pane_11">{{ __('translation.ownersale_info') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#kt_tab_pane_12">
                                        {{ __('translation.realstate_installment') }}</a>
                                </li>
                                @endif
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
                                                                @if($realState->type == 'rent')
                                                                <th scope="row">{{ __('translation.is_rented') }}</th>
                                                                <td>{!! $realState->getSaleStatusWithSpan('is_rent' , 'rented') !!}</td>
                                                                @else
                                                                <th scope="row">{{ __('translation.is_saled') }}</th>
                                                                <td>{!! $realState->getSaleStatusWithSpan('is_sale' , 'saled') !!}</td>
                                                                @endif

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
                                </table>
                            </div>

                            <div class="tab-pane fade" id="kt_tab_pane_10" role="tabpanel">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <h3 class='p-2'>
                                            {{__('translation.Revenues_history')}}
                                        </h3>
                                        <div class="btn-group">
                                            <div class="" style='display:inline ;margin:3px'>
                                                <a href="{{route('realstate.receipt' , $realState->id)}}"
                                                class="btn btn-primary btn-sm">
                                                    {{__('translation.receipt_of_revenue')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                                        <thead>
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase ">
                                                <th class="">{{ __('translation.name') }}</th>
                                                <th class="">{{ __('translation.phone') }}</th>
                                                <th class="">{{ __('translation.month_number') }}</th>
                                                <th class="">{{ __('translation.amount') }}</th>
                                                <th class="">{{ __('translation.rent_status') }}</th>
                                                <th class="">{{ __('translation.from_date') }}</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @forelse ($realState->Revenues->reverse() as $item)
                                               <tr>

                                                    <td> {{ $item->name }}</td>
                                                    <td> {{ $item->phone }}</td>
                                                    <td> {{ $item->pivot->month_number }}</td>
                                                    <td> {{ $item->pivot->price }}</td>
                                                    <td>
                                                        @if ($item->pivot->status)
                                                        <span class='badge badge-light-success'>{{__('translation.pay_done')}} </span>
                                                        @else
                                                        <span class='badge badge-light-danger'>{{__('translation.pay_undone')}} </span>
                                                            @endif
                                                    </td>
                                                    <td> {{$item->created_at->format('y-m-d')}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td collspan='12'>
                                                        {{__('translation.no_data_found')}}
                                                    </td>
                                                </tr>
                                                @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="kt_tab_pane_11" role="tabpanel">
                                <div>
                                    <div class="d-flex justify-content-between">
                                        <h3 class='p-2'>
                                            {{__('translation.ownersale_info')}}
                                        </h3>
                                    </div>
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="">
                                        <thead>
                                            <tr class=" text-gray-400 fw-bolder fs-7 text-uppercase ">
                                                <th>{{ __('translation.id') }}</th>
                                                <th>{{ __('translation.name') }}</th>
                                                <th>{{ __('translation.phone') }}</th>
                                                <th>{{ __('translation.workplace') }}</th>
                                                <th>{{ __('translation.identification_type') }}</th>
                                                <th>{{ __('translation.identification_number') }}</th>
                                                <th>{{ __('translation.status') }}</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                    <tbody class="fw-bold text-gray-600">
                                        @forelse ($realState->CurrentOwner as $item)
                                               <tr>

                                                    <td> {{ $item->name }}</td>
                                                    <td> {{ $item->phone }}</td>
                                                    <td> {{ $item->workplace }}</td>
                                                    <td> {{ $item->identification_type }}</td>
                                                    <td> {{ $item->identification_number }}</td>
                                                    <td>
                                                        {!! $item->getStatusWithSpan() !!}
                                                    </td>
                                                    <td> {{$item->created_at->format('y-m-d')}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td collspan='12'>
                                                        {{__('translation.no_data_found')}}
                                                    </td>
                                                </tr>
                                                @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

