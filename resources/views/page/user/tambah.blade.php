@extends('layouts.app')
@section('title','Create New Users')
@section('breadcrumb')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6"><h5 class="mb-2">Create New Users</h5></div>
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
                <div class="card-header"><div class="card-title">Create New Users</div></div>
                <!--end::Header-->
                <!--begin::Form-->
                <form action='javascript:void(0)' enctype="multipart/form-data" id="form_data">
                    @csrf
                    @method("post")
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="row mb-3">
                            <label for="nama" class="col-sm-3 col-form-label">Nama <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="level" class="col-sm-3 col-form-label">Level <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <select name="level" id="level" class='form-control level'>
                                    <option value="">..:: Pilih Level ::..</option>
                                    <option value="admin">Admin</option>
                                    <option value="pimpinan">Pimpinan</option>
                                    <option value="pegawai">Pegawai</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="pegawai_id" class="col-sm-3 col-form-label">Data Pegawai <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <select name="pegawai_id" id="pejabat_id" class='pegawai_id form-control'>
                                    <option value="">..:: Pilih Data Pegawai ::..</option>
                                </select>
                            </div>
                        </div>
                        <hr />
                        <div class="row mb-3">
                            <label for="username" class="col-sm-3 col-form-label">Username <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-sm-3 col-form-label">Password <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password_confirmation" class="col-sm-3 col-form-label">Password Komfirmasi <b class='text-danger'>*</b></label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Password Komfirmasi" />
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
    $('.pegawai_id').select2({
        ajax: {
            url: '{{ route("pegawai.list") }}',
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
        placeholder: "-- Pilih Pegawai --",
        allowClear: true
    });
    $('.level').select2({
        theme: 'bootstrap4',
        width: 'resolve',
        placeholder: "-- Pilih Level --",
        allowClear: true,
        minimumResultsForSearch: -1, // -1 = search box selalu disembunyikan
        escapeMarkup: markup => markup
    });
    $(".level").on("change", function(){
        var level = $(this).val();
    });
    
    proses_data = function(){
        let iData = new FormData(document.getElementById("form_data"));
        $.ajax({
            type    : "POST",
            url     : "{{ route('user.save') }}",
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

