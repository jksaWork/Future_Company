{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('owners.show', $id) }}" class="btn btn-light-primary btn-sm btn-icon">
        <i class="fa fa-eye"></i>
    </a>
</div>
{{-- @endif --}}
