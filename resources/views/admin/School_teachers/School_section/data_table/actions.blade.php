{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('School.section.edit', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('translation.edit')</a>
   
</div>
{{-- @endif --}}
