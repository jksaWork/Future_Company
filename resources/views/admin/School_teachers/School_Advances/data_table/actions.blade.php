{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('School.Advances.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('translation.edit')</a>
    <form action="{{ route('School.Advances.destroy', $id) }}"  id={{$id}} class="my-1 my-xl-0" method="post" style="display: inline-block;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger btn-sm delete" onclick="event.preventDefault();
        DeleteApp({{$id}})"><i class="fa fa-trash"></i> @lang('translation.delete')</button>
    </form>
</div>
{{-- @endif --}}
