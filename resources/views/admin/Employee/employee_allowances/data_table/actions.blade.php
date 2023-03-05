{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('Employee.employee_allowances.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('translation.edit')</a>
    <form action="{{ route('Employee.employee_allowances.destroy', $id) }}"   id='delteForm' class="my-1 my-xl-0" method="post" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete" onclick="event.preventDefault();
        DeleteApp('delteForm')"><i class="fa fa-trash"></i> @lang('translation.delete')</button>
    </form>
</div>
{{-- @endif --}}
