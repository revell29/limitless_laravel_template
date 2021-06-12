@extends('layouts.master')
@section('title', 'List Obat')
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
<a href="{{route('obat.create')}}" class="btn btn-md btn-primary">
    <i class="icon-plus-circle2 mr-2"></i>
    <span>Tambah Obat</span>
</a>
@endslot
@slot('breadcumbs')
<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> / Data Obat</h4>
<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
@endslot
@slot('breadcumbs2')

@endslot
@endcomponent
<div class="content">
    <div class="card">


        <table class="table table-hover table-bordered table-xs datatable-select-checkbox" id="data-table" data-url="{{route('obat.index')}}">
            <thead>
                <tr>
                    <th><input type="checkbox" class="styled" id="select-all"></th>
                    <th>Nama Obat</th>
                    <th>Harga</th>
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
            url: '{{route('obat.index')}}',
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
                { data: 'nama_obat', name: 'nama_obat' },
                { data: 'harga', name: 'harga' },
            ]
        });
</script>
<script type="text/javascript" src="/custom/custom.js"></script>
@endpush