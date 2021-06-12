@extends('layouts.master')
@section('title', 'Data Pasien')
@section('scripts')
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/tables/datatables/extensions/select.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/notifications/sweet_alert.min.js"></script>
<script type="text/javascript" src="/global_assets/js/plugins/ui/moment/moment.min.js"></script>
<script type="text/javascript" src="/custom/datatables.js"></script>
@endsection
@section('content')
@component('layouts.component.header')
@slot('tools')
<a href="{{route('pasien.create')}}" class="btn btn-md btn-primary">
  <i class="icon-plus-circle2 mr-2"></i>
  <span>Tambah Pasien</span>
</a>
@endslot
@slot('breadcumbs')
<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> Data Pasien</h4>
<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
@endslot
@slot('breadcumbs2')
<a href="{{url('/backend/home')}}" class="breadcrumb-item">Home</a>
<span class="breadcrumb-item active">Data Pasien</span>
@endslot
@endcomponent
<div class="content">
  <div class="card">
    <div class="card-header header-elements-inline">
      <h5 class="card-title"></h5>
      <div class="header-elements">
        <div class="list-icons">
          <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item" data-action="reload"></a>
          <a class="list-icons-item" data-action="remove"></a>
        </div>
      </div>
    </div>

    <table class="table table-hover table-bordered table-xs datatable-select-checkbox" id="data-table" data-url="{{route('pasien.index')}}">
      <thead>
        <tr>
          <th><input type="checkbox" class="styled" id="select-all"></th>
          <th>Nama Pasien</th>
          <th>No HP</th>
          <th>Jenis Kelamin</th>
          <th>Umur</th>
          <th>Created At</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@endsection

@push('javascript')
<script>
  var table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            order: [1 , 'desc'],
            ajax: {
            url: '{{route('pasien.index')}}',
            data: function (d) {
                d.datefrom = $('input[name=datefrom]').val();
            },
            method: 'GET'
        },
            columnDefs: [{
                targets: 0,
                createdCell: function(td, cellData) {
                    if (cellData != 0 ){
                        $(td).addClass('select-checkbox')
                    }
                }
            }],
            columns: [
                { data: 'id', name: 'id', width: '50px', orderable: false, render: function() { return ''} },
                { data: 'nama_pasien', name: 'nama_pasien' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'jenis_kelamin', name: 'jenis_kelamin' },
                { data: 'umur', name: 'umur' },
                { data: 'created_at', name: 'created_at' },
            ]
        });
</script>
<script type="text/javascript" src="/custom/custom.js"></script>
@endpush