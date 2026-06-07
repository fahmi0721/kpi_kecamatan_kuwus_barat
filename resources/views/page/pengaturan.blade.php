@extends('layouts.app')
@section('title','Pengaturan Umum')
@section('breadcrumb')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6"><h5 class="mb-2">Pengaturan Umum</h5></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengaturan Umum</li>
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
        <div class="col-10">
            <div class="card card-success card-outline mb-4">
                <div class="card-header"><div class="card-title">Pengaturan Umum</div></div>
                <!--end::Header-->
                <!--begin::Form-->
                <form action='javascript:void(0)' enctype="multipart/form-data" id="form_data">
                    @csrf
                    @method("post")
                <!--begin::Body-->
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="nama_aplikasi" class="col-sm-3 col-form-label">Nama Sistem <b class='text-danger'>*</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $data->nama_sistem }}" id="nama_sistem" name="nama_sistem" placeholder="Nama Sistem" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nama_sekolah" class="col-sm-3 col-form-label">Nama Sekolah <b class='text-danger'>*</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" value="{{ $data->nama_sekolah }}" id="nama_sekolah" name="nama_sekolah" placeholder="Nama Sekolah" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="max_day_pinjam" class="col-sm-3 col-form-label">Maksimal Hari Pinjaman <b class='text-danger'>*</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" onkeyup="formatRupiah(this)" value="{{ number_format($data->max_day_pinjam,0,',','.') }}" id="max_day_pinjam" name="max_day_pinjam" placeholder="Maksimal Hari Pinjaman" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="max_count_pinjam" class="col-sm-3 col-form-label">Maksimal Jumlah Pinjaman <b class='text-danger'>*</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" onkeyup="formatRupiah(this)" value="{{ number_format($data->max_count_pinjam,0,',','.') }}" id="max_count_pinjam" name="max_count_pinjam" placeholder="Maksimal Jumlah Pinjaman" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="nominal_denda" class="col-sm-3 col-form-label">Nominal Denda <b class='text-danger'>*</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" onkeyup="formatRupiah(this)" value="{{ number_format($data->nominal_denda,0,',','.') }}" id="nominal_denda" name="nominal_denda" placeholder="Nominal Denda" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="max_day_denda" class="col-sm-3 col-form-label">Maksimal Hari Denda <b class='text-danger'>*</b></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" onkeyup="formatRupiah(this)" value="{{ number_format($data->max_day_denda,0,',','.') }}" id="max_day_denda" name="max_day_denda" placeholder="Maksimal Hari Denda" />
                        </div>
                    </div>
                    
                </div>
                <!--end::Body-->
                <!--begin::Footer-->
                <div class="card-footer">
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
        
    })
    proses_data = function(){
        let iData = new FormData(document.getElementById("form_data"));
        $.ajax({
            type    : "POST",
            url     : "{{ route('pengaturan.save') }}",
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
                        window.location.href = "{{ route('pengaturan') }}";
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

