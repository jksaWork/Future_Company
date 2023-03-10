@if (auth()->user()->hasPermission('update_admins'))
    <a href="{{ route('admin.user.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('translation.edit')</a>
@endif

@if (auth()->user()->hasPermission('delete_admins'))
    <form action="{{ route('admin.user.destroy', $id) }}" class="my-1 my-xl-0" method="post" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> @lang('translation.delete')</button>
    </form>
@endif
