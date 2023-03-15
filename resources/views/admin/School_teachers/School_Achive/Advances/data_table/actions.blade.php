{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('School_Achive.School_Advances.Achives.feedback', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('translation.feedback')</a>
   
</div>
{{-- @endif --}}
