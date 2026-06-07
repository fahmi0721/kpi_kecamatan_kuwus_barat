@extends('layouts.app')
@section('title','Update Users')
@section('breadcrumb')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6"><h5 class="mb-2">Update Users</h5></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user') }}">Users</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
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
            <div class="card card-success card-outline mb-4">
                <div class="card-header"><div class="card-title">Update Users</div></div>
                <!--end::Header-->
                <!--begin::Form-->
                <form action='javascript:void(0)' enctype="multipart/form-data" id="form_data">
                    @csrf
                    @method("put")
                    <input type="hidden" name='id' value='{{ $id }}'>
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="nama" class="col-sm-3 col-form-label">Nama <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" value="{{ $data->nama }}" id="nama" name="nama" placeholder="Nama" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="level" class="col-sm-3 col-form-label">Level <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <select name="level" id="level" class='form-select form-control'>
                                    <option value="">..:: Pilih Level ::..</option>
                                    <option value="admin" @if($data->level == "admin") selected @endif>Admin</option>
                                    <option value="pegawai" @if($data->level == "pegawai") selected @endif>Pegawai</option>
                                    <option value="siswa" @if($data->level == "siswa") selected @endif>Siswa</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="data_id" class="col-sm-3 col-form-label">Data Pengguna <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <select name="data_id" id="data_id" class='data_id form-control'>
                                    <option value="">..:: Pilih Data Pengguna ::..</option>
                                </select>
                            </div>
                        </div>
                        <hr />
                        <div class="row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Username <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" readonly value="{{ $data->username }}" class="form-control" id="username" name="username" placeholder="Username" />
                            </div>
                        </div>
                        
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                      <a href="{{ route('user') }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-mail-reply"></i> Kembali</a>
                      <button type="submit" id="btn-submit" class="btn btn-success btn-flat btn-sm float-end"><i class="fa fa-save"></i> Simpan</button>
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
    $(document).ready(function(){
        data_id("siswa");
    }).
    $("#level").on("change", function(){
        var level = $(this).val();
        data_id(level);
    });
    function data_id(level){
        $('.data_id').select2({
            ajax: {
                url: '{{ route("user.data") }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term,
                        level: level
                    };
                },
                processResults: data => ({
                    results: data.map(q => ({ id: q.id, text: q.nama }))
                }),
                cache: true
            },
            theme: 'bootstrap4',
            width: 'resolve',
            placeholder: "-- Pilih Data Pengguna --",
            allowClear: true,
            minimumResultsForSearch: -1, // -1 = search box selalu disembunyikan
            escapeMarkup: markup => markup
        });
        @if(!empty($data->data_id))
        var option = new Option("{{ $data->data_relasi->nama }}", {{ $data->data_relasi->id }}, true, true);
        $(".data_id").append(option).trigger('change');    
    @endif
    }
    proses_data = function(){
        $("#username").prop("disabled",false);
        var id = $("#id").val();
        let iData = new FormData(document.getElementById("form_data"));
        $.ajax({
            type    : "POST",
            url     : "{{ route('user.update', ':id') }}".replace(':id', id),
            data    : iData,
            cache   : false,
            processData: false,
            contentType: false,
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
                    title = "Saved!";
                    info(title,pesan,icons,position);
                    $("#btn-submit").html("<i class='fa fa-save'></i> Simpan")
                    $("#btn-submit").prop("disabled",false);
                    setTimeout(() => {
                        window.location.href = "{{ route('user') }}";
                    }, 2000);
                    
                }
            },
            error: function(e){
                console.log(e)
                $("#btn-submit").html("<i class='fa fa-save'></i> Simpan")
                $("#btn-submit").prop("disabled",false);
                error_message(e,'Proses Data Error');
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

