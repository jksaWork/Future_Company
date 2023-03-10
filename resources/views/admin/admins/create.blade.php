{{-- @extends('layouts.admin.admin') --}}
@extends(auth()->guard('admin')->check() ?'layouts.admin.admin':'layouts.agents.agent_layouts')

@section('main-head' , __('translation.add_new_users'))
@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
        <div class="card p-5">
            <div class="card-body p-3">
    <div class="row">
        <form action="{{route('users.store')}}" method="post">
            @csrf
        <div class="col-md-12">
            <div class="card p-4">
                <div class="row">
                    <x:text-input class="col-md-6" name='name'  />
                    <x:text-input class="col-md-6" name='email'  />
                    <x:text-input class="col-md-6" name='password'  />
                    <x:text-input class="col-md-6" name='phone'  />
                        @if (auth()->guard('web')->check())
                            <x:text-input name='agent_id' class='col-md-6' value="{{auth()->user()->agent_id ?? ''}}" />
                        @endif
                    <div class="col-md-6  {{ !auth()->guard('web')->check() ?: 'd-none'}}">
                        <div class="form-group">
                            <label for=""> {{__('translation.Roles')}}</label>
                            <select class="form-control" name="role_id" id="" >
                                @foreach ($roles as $item)
                                <option value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <span class="text-danger">
                                    {{$message}}
                                </span>
                                @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn-primary btn">
                            {{__('translation.Save')}}
                        </button>
                        <a href="#" onclick="window.history.back()" class="btn btn-light-danger">
                            {{__('translation.cancel')}}
                        </a>
                    </div>
                </div>
            </div><!-- end of tile -->
        </div><!-- end of col -->
    </form>
    </div>
</div><!-- end of row -->
        </div>
        </div>
    </div>
@endsection

@push('scripts');
<script src="{{ asset('admin_assets/js/custom/index.js')}}"></script>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script>
    // alert('worgiing');
        let rolesTable = $('#roles-table').DataTable({
            dom: "tiplr",
            serverSide: true,
            processing: true,
            "language": {
                "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },
            ajax: {
                url: '{{ route('admin.admins.data') }}',
            },
            columns: [
                {data: 'record_select', name: 'record_select', searchable: false, sortable: false, width: '1%'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email', searchable: false},
                {data: 'roles', name: 'roles', searchable: false},
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'actions', name: 'actions', searchable: false, sortable: false, width: '20%'},
            ],
            order: [[3, 'desc']],
            drawCallback: function (settings) {
                $('.record__select').prop('checked', false);
                $('#record__select-all').prop('checked', false);
                $('#record-ids').val();
                $('#bulk-delete').attr('disabled', true);
            }
        });

        $('#data-table-search').keyup(function () {
            rolesTable.search(this.value).draw();
        });
</script>

@endpush
