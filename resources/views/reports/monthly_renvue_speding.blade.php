{{-- @extends('layouts.admin.admin') --}}
@extends('layouts.admin.admin')
@section('main-head', __('translation.MonthlyRealstateRenvueAndSpending_2'))
@section('content')
<div class="post d-flex flex-column-fluid" id="kt_post">
     <!--begin::Container-->
     <div id="kt_content_container" class="container-xxl">
          <!--begin::Card-->
          <div class="card">
               <!--begin::Card header-->
               {{-- <div class="card-header border-0 pt-6"> --}}
                   <div class="p-2 m-2">
                    <div class="row p-3 m-2">
                        <div class="form-group col-md-6">
                            <label for="">{{ __('translation.chose_year') }}</label>
                            <select class="form-control col-md-6" name="" id="year_number">
                                @foreach ([23, 24,25, 26, 25] as $year)
                                <option value='20{{ $year }}'>20{{ $year }}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="">{{ __('translation.chose_month') }}</label>
                            <select class="form-control " name="" id="month_number">
                                @for ($i = 1; $i < 13; $i++)
                                            <option value='{{$i}}'> {{$i . ' -- '. __('translation.'. date("M", mktime(null, null, null, $i, 1)));}}</option>
                                @endfor
                            </select>
                    </div>
               </div>
                   </div>
               <!--end::Card header-->
               <!--begin::Card body-->
               <div class="card-body pt-0">
                    @include('layouts.includes.session')
                    <div class="row">
                         <div class="col-md-12">
                              <div class="table-responsive">
                                   <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable "
                                        id="roles-table" style="width: 100%;">
                                        <thead>
                                             <tr>
                                                  <th>{{ __('translation.year') }}</th>
                                                  <th>{{ __('translation.month') }}</th>
                                                  <th>{{ __('translation.credit_total') }}</th>
                                                  <th>{{ __('translation.debit_total') }}</th>
                                                  <th>{{ __('translation.total') }}</th>
                                             </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class='table-success'>
                                                <th colspan="2" style="text-align:center">{{ __('translation.total') }} : </th>
                                                <th id='credit_total' style="font-weight:bolder">0</th>
                                                <th id='debit_total' style="font-weight:bolder">0</th>
                                                <th id='total_total' style="font-weight:bolder">0</th>
                                            </tr>
                                        </tfoot>
                                   </table>
                              </div><!-- end of table responsive -->
                         </div><!-- end of col -->
                    </div><!-- end of row -->
                    <!--end::Table-->
               </div>
               <!--end::Card body-->
          </div>
          <!--end::Card-->
          <!--end::Modals-->
     </div>
     <!--end::Container-->
</div>
@endsection
@push('scripts')
<script src="{{ asset('admin_assets/js/custom/index.js') }}"></script>
<script>
let role, year, month;
let rolesTable = $('#roles-table').DataTable({
     dom: "Brtip",
     serverSide: true,
     processing: true,
     "language": {
          "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
     },
     buttons: [
          'copy', {
               extend: 'excel',
               text: '{{ __('translation.export_As_exel') }}',
          },

          {
               extend: 'print',
               title: "@lang('translation.MonthlyRealstateRenvueAndSpending_2')",
               className: 'btn btn-default',
               autoPrint: true,
               customize: function(win) {
                    $(win.document.body).css('direction', 'rtl');
                    $(win.document.body).find('th').addClass('display').css('text-align', 'center');
                    $(win.document.body).find('table').addClass('display').css('font-size', '16px');
                    $(win.document.body).find('table').addClass('display').css('text-align',
                         'center');
                    $(win.document.body).find('tr:nth-child(odd) td').each(function(index) {
                         $(this).css('background-color', '#D0D0D0');
                    });
                    $(win.document.body).find('h1').css('text-align', 'center');
               }
          }

     ],
     ajax: {
          url: '{{ route('reports.MonthData') }}',
          data:function(q){
            q.year = year;
            q.month = month;
          }

     },
     columns: [
        {
               data: 'yea',
               name: 'yea   '
          },
        {
               data: 'month_name',
               name: 'month_name'
          },

          {
               data: 'credit_total',
               name: 'credit_total'
          },
          {
               data: 'debit_total',
               name: 'debit_total'
          },
          {
               data: 'total',
               name: 'total'
          },
     ],
     order: [
          [2, 'desc']
     ],
     drawCallback: function(settings) {
          $('.record__select').prop('checked', false);
          $('#record__select-all').prop('checked', false);
          $('#record-ids').val();
          $('#bulk-delete').attr('disabled', true);
     },
     footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            total = api
                .column(2)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            pageTotal = api
                .column(2, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                pageTotal2 = api
                .column(3, { page: 'current' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                console.log(pageTotal, 'credit   --------------');
                console.log(pageTotal2, 'debit   --------------');
            // Update footer

            $(api.column(4).footer()).html(`${new Intl.NumberFormat().format(pageTotal - pageTotal2)}`);
            $(api.column(2).footer()).html(`${new Intl.NumberFormat().format(pageTotal)}`);
            $(api.column(3).footer()).html(`${new Intl.NumberFormat().format(pageTotal2)}`);
        },
});

$('#handelSearch').keyup(function() {
     rolesTable.search(this.value).draw();
     // role = $(this).val();
     // rolesTable.ajax.reload();
});
$('#year_number').on('change', function() {
     year = $(this).val();
     rolesTable.ajax.reload();
});

$('#month_number').on('change', function() {
     month = $(this).val();
     rolesTable.ajax.reload();
});
</script>
@endpush
