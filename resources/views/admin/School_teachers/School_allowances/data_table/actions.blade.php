{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('School.allowances.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('translation.edit')</a>
    <form action="{{ route('School.allowances.destroy', $id) }}" class="my-1 my-xl-0" method="post"  id={{$id}} style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete"  onclick="event.preventDefault();
        DeleteApp({{$id}})"><i class="fa fa-trash"></i> @lang('translation.delete')</button>
    </form>
</div>
{{-- @endif --}}
