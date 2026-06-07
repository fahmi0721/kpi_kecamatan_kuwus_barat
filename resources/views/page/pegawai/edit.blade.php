@extends('layouts.app')
@section('title','Update Data Pegawai')
@section('breadcrumb')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6"><h5 class="mb-2">Update Data Pegawai</h5></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pegawai') }}">Pegawai</a></li>
            <li class="breadcrumb-item active" aria-current="page">Update</li>
        </ol>
        </div>
    </div>
    <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-8">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Update Data Pegawai</div></div>
                <!--end::Header-->
                <!--begin::Form-->
                <form action='javascript:void(0)'  id="form_data">
                    @csrf
                    @method("put")
                    <input type="hidden" value="{{ $id }}" id='id' name='id'>
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="nip" class="col-sm-3 col-form-label">NIP <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->nip }}" id="nip" name="nip" placeholder="NIP" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nama" class="col-sm-3 col-form-label">Nama <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->nama }}" id="nama" name="nama" placeholder="Nama" />
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="jk" class="col-sm-3 col-form-label">Jenis Kelamin <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="radio"  id="jk" name="jk" value='L' @if($data->jk == "L") checked @endif /> Laki- Laki <br>
                                <input type="radio"  id="jk" name="jk" value='P' @if($data->jk == "P") checked @endif /> Perempuan
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="alamat" class="col-sm-3 col-form-label">Alamat <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->alamat }}" id="alamat" name="alamat" placeholder="Alamat" />
                            </div>
                        </div>
                    
                        <div class="row mb-3">
                            <label for="jabatan_id" class="col-sm-3 col-form-label">Jabatan</label>
                            <div class="col-sm-9">
                                <select name="jabatan_id" id="jabatan_id" class='form-control jabatan_id'>
                                    <option value="">Pilih Jabatan</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="no_hp" class="col-sm-3 col-form-label">No HP <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="no_hp" value="{{ $data->no_hp }}" name="no_hp" placeholder="No HP" />
                            </div>
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <a href="{{ route('pegawai') }}"  class="btn btn-danger btn-flat btn-sm"><i class="fa fa-mail-reply"></i> Kembali</a>
                      <button type="submit" id="btn-submit" class="btn btn-primary btn-flat btn-sm float-end"><i class="fa fa-save"></i> Simpan</button>
                  </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>  
        </div>
    </div>    
</div>
@endsection
@section('js')
<script>
    $('.jabatan_id').select2({
        ajax: {
            url: '{{ route("jabatan.list") }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(function(q){
                        return {id: q.id, text:  q.text};
                    })
                };
            },
            cache: true
        },
        theme: 'bootstrap4',
        width: '100%',
        placeholder: "-- Pilih Jabatan --",
        allowClear: true
    });
    @if(!empty($data->jabatan))
        var option = new Option("{{ $data->jabatan->nama }}", {{ $data->jabatan->id }}, true, true);
        $(".jabatan_id").append(option).trigger('change');    
    @endif
    proses_data = function(){
        let iData = $("#form_data").serialize();
        var id = $("#id").val();
        $.ajax({
            type    : "POST",
            url     : "{{ route('pegawai.update', ':id') }}".replace(':id', id),
            data    : iData,
            cache   : false,
            beforeSend  : function (){
                $("#btn-submit").html("<i class='fa fa-spinner fa-spin'></i>  Simpan..")
                $("#btn-submit").prop("disabled",true);
            },
            success: function(result){
                console.log(result)
                if(result.status == "success"){
                    position = "bottom-left";
                    icons = result.status;
                    pesan = result.messages;
                    title = "Updated!";
                    info(title,pesan,icons,position);
                    $("#btn-submit").html("<i class='fa fa-save'></i> Simpan")
                    $("#btn-submit").prop("disabled",false);
                    setTimeout(() => {
                        window.location.href = "{{ route('pegawai') }}";
                    }, 2000);
                    
                }
            },
            error: function(e){
                console.log(e)
                $("#btn-submit").html("<i class='fa fa-save'></i> Simpan")
                $("#btn-submit").prop("disabled",false);
                error_message(e,'Server Error!');
            }
        })
    }

    $(function() {
        $("#form_data").submit(function(e){
            e.preventDefault();
            proses_data();
        });
    });
</script>
@endsection

