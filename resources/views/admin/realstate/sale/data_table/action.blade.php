{{-- @if (auth()->user()->hasPermission('update_admins')) --}}
<div style="min-width: 200px">
    <a href="{{ route('realstate.realstate.show', $id) }}" class="btn btn-light-primary mx-2 btn-sm btn-icon">
        <i class="fa fa-eye"></i>
    </a>
    <a href="{{ route('realstate.sale_invoice', $id) }}" class="btn btn-info btn-sm btn-icon">
        <i class="bi bi-printer"></i>
    </a>
</div>
{{-- @endif --}}
