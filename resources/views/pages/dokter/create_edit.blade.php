@extends('layouts.master')
@section('title', 'dokter Form')

@section('content')
@component('layouts.component.header')
@slot('tools')

@endslot
@slot('breadcumbs')
<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> / dokter /
  {{isset($data) ? 'Edit dokter' : 'Create dokter'}}</h4>
<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
@endslot
@slot('breadcumbs2')
<a href="{{url('/backend/home')}}" class="breadcrumb-item"> Home</a>
<a href="{{route('dokter.index')}}" class="breadcrumb-item">Data Dokter</a>
<span class="breadcrumb-item active">{{isset($data) ? 'Edit dokter' : 'Create dokter'}}</span>
@endslot
@endcomponent
<!-- Main content -->
<div class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form id="form-user" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-6">
                <div class="form-group">
                  <label for="">NIP</label>
                  <input type="text" name="nip" class="form-control" id="" value="{{isset($data) ? $data->nip : null}}">
                </div>
                <div class="form-group">
                  <label for="">Nama Dokter</label>
                  <input type="text" name="nama_dokter" class="form-control" id="" value="{{isset($data) ? $data->nama_dokter : null}}">
                </div>
                <div class="form-group">
                  <label for="">Spesial</label>
                  <input type="text" name="spesialis" class="form-control" id="" value="{{isset($data) ? $data->spesialis : null}}">
                </div>
                <div class="form-group">
                  <label for="">No HP</label>
                  <input type="text" name="no_hp" class="form-control" id="" value="{{isset($data) ? $data->no_hp : null}}">
                </div>
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="text" name="email" class="form-control" id="" value="{{isset($data) ? $data->email : null}}">
                </div>
                <div class="form-group">
                  <label for="">Jadwal</label>
                  <textarea name="jadwal" class="form-control">{{ isset($data) ? $data->jadwal : null }}</textarea>
                </div>
              </div>
              <div class="col-6">
                <div class="form-group">
                  <label for="">Alamat</label>
                  <textarea name="alamat" class="form-control">{{ isset($data) ? $data->alamat : null }}</textarea>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="card-footer">
          <div class="text-right">
            <button type="button" id="save" class="btn btn-md btn-primary pull-right">Submit</button>
            <a href="{{route('pasien.index')}}" class="btn btn-md btn-danger">Back</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('javascript')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Pasien\PasienRequest') !!}

<script>
  $('#save').on("click",function(){
    let btn = $(this);
    let form = $('#form-user');
    if(form.valid()) {
        $.ajax({
            url: "{{isset($data) ? route('dokter.update',$data->id) : route('dokter.store')}}",
            method: "{{isset($data) ? 'PATCH' : 'POST'}}",
            data: $('#form-user').serialize(),
            dataType: 'JSON',
            beforeSend: function(){
                btn.html('Please wait').prop('disabled',true);
            },
            success: function(response){
                swalInit.fire({
                    title: "Success!",
                    text: response.message,
                    type: 'success',
                    buttonStyling: false,
                    confirmButtonClass: 'btn btn-primary btn-lg',
                }).then(function() {
                    window.location.href = "{{route('dokter.index')}}";
                })
            },
            error: function(response){
                if(response.status == 500){
                    console.log(response)
                    swalInit.fire("Error", response.responseJSON.message,'error');
                }
                if(response.status == 422){
                    var error = response.responseJSON.errors;
                    
                }
                btn.html('Submit').prop('disabled',false);
            }
        });
    }    
});
</script>
@endpush