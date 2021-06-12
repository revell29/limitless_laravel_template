@extends('layouts.master')
@section('title', 'User Form')

@section('content')
@component('layouts.component.header')
@slot('tools')

@endslot
@slot('breadcumbs')
<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> / User /
  {{isset($data) ? 'Edit User' : 'Create User'}}</h4>
<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
@endslot
@slot('breadcumbs2')
<a href="{{url('/backend/home')}}" class="breadcrumb-item"> Home</a>
<a href="{{route('user.index')}}" class="breadcrumb-item">Data Pasien</a>
<span class="breadcrumb-item active">{{isset($data) ? 'Edit Pasien' : 'Create User'}}</span>
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
                  <label for="">Nama Pasien</label>
                  <input type="text" name="nama_pasien" class="form-control" id="" value="{{isset($data) ? $data->nama_pasien : null}}">
                </div>
                <div class="form-group">
                  <label for="">Umur</label>
                  <input type="number" name="umur" class="form-control" id="" value="{{isset($data) ? $data->umur : null}}">
                </div>
                <div class="form-group">
                  <label for="">Jenis Kelamin</label>
                  {!! Form::select('jenis_kelamin',$options['gender'], isset($data) ? $data->jenis_kelamin : null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                  <label for="">No HP</label>
                  <input type="text" name="no_hp" class="form-control" id="" value="{{isset($data) ? $data->no_hp : null}}">
                </div>
                <div class="form-group">
                  <label for="">No KTP/SIM</label>
                  <input type="text" name="no_ktp" class="form-control" id="" value="{{isset($data) ? $data->no_ktp : null}}">
                </div>
                <div class="form-group">
                  <label for="">Tempat Lahir</label>
                  <input type="text" name="tempat_lahir" class="form-control" id="" value="{{isset($data) ? $data->tempat_lahir : null}}">
                </div>
                <div class="form-group">
                  <label for="">Tanggal Lahir</label>
                  <input type="date" name="tanggal_lahir" class="form-control" id=""
                    value="{{isset($data) ? \Carbon\Carbon::parse($data->tanggal_lahir)->format('Y-m-d') : null}}">
                </div>
              </div>
              <div class="col-6">
                <label for="">Alamat Pasien</label>
                <textarea name="alamat" rows="5" class="form-control">{{ isset($data) ? $data->alamat : null }}</textarea>
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
            url: "{{isset($data) ? route('pasien.update',$data->id) : route('pasien.store')}}",
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
                    window.location.href = "{{route('pasien.index')}}";
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