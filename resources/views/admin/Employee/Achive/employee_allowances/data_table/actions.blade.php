{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('Achive.employee_allowances.Achives.feedback', $id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('translation.feedback')</a>
   
</div>
{{-- @endif --}}
