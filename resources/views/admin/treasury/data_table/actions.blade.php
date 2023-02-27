{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
@if ($transaction_type == 'main_treasury')
<div style="min-width: 200px">
    <a href="#"
    data-bs-toggle="modal" data-bs-target="#kt_modal_add_customer_{{ $id }}"
    class="btn btn-light-primary  btn-sm">
        {{ __('translation.edit_amount') }}
    </a>
</div>

<div class="modal fade" id="kt_modal_add_customer_{{ $id }}" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="{{ route('admin.finanical.update' , $id) }}" method="post">
                @csrf
                @method('PUT')
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_customer_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bolder">{{ __('translation.add_real_state_category') }}</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_modal_add_customer_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16"
                                    height="2" rx="1" transform="rotate(-45 6 17.3137)"
                                    fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2"
                                    rx="1" transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <!--begin::Scroll-->
                    <div class="scroll-y me-n7 pe-7" id="#">
                        <!--begin::Input group-->
                        <x:text-input name='amount' value='{{ $amount }}' class='col-md-12' />
                        <!--end::Input group-->
                        <x:text-area class='col-md-12' value='{{ $note }}' name='note'></x:text-area>
                        <!--begin::Input group-->
                    </div>
                    <!--end::Scroll-->
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer ">
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel"
                        class="btn btn-light me-3">{{ __('translation.cancel') }}</button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button class="btn btn-primary"> {{ __('translation.add_to_trnsury') }} </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
@else

@endif
{{-- @endif --}}
