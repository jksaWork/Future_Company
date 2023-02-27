{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('realstate.realstate.show', $id) }}" class="btn btn-light-primary btn-sm btn-icon">
        <i class="fa fa-eye"></i>
    </a>

    <form id='end_real_state_rent_{{$id}}'
     action="{{ route('realstate.FinshRent', $id) }}" class="my-1 my-xl-0" method="post">
        @csrf
        <input  type='hidden' name='real_state_id' value='{{$id}}'/>
        <button type="submit"
        data-element='end_real_state_rent_{{$id}}' class="btn btn-light-danger btn-sm delete end_rent_btn">
            {{__('translation.finsh_the_currnt_rent')}}
        </button>
    </form>
</div>
{{-- @endif --}}
