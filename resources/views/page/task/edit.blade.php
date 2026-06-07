@extends('layouts.app')
@section('title','Update Data Tugas Harian')
@section('breadcrumb')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6"><h5 class="mb-2">Update Data Tugas Harian</h5></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('task') }}">Data Tugas Harian</a></li>
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
    <form action='javascript:void(0)' enctype="multipart/form-data" id="form_data">
    @csrf
    @method("put")
    <input type="hidden" value="{{ $id }}" id='id' name='id'>
    <div class="row">
        <div class="col-9">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Update Data Tugas Harian</div></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="judul" class="form-label">
                            Jurul Tugas <b class="text-danger">*</b>
                        </label>

                        <input type="text" 
                            class="form-control" 
                            name="judul" 
                            id="judul" 
                            value="{{ $data->judul }}"
                            placeholder="Judul">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">
                            Tanggal <b class="text-danger">*</b>
                        </label>

                        <input type="text" 
                            class="form-control" 
                            name="tanggal" 
                            id="tanggal" 
                            value="{{ $data->tanggal }}"
                            placeholder="Tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="isbn" class="form-label">
                            Uraian <b class="text-danger">*</b>
                        </label>

                        <textarea type="text" 
                            class="form-control uraian" 
                            name="uraian" 
                            id="uraian" 
                            row="5"
                            placeholder="Uraian">{{ $data->uraian }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="dokumentasi" class="form-label">
                            Dokumentasi 
                        </label>

                        <input type="file" 
                            class='form-control' 
                            name='dokumentasi' id='dokumentasi' 
                            placeholder='Cover'>
                    </div>
                </div>
                <!--end::Form-->
            </div>  
        </div>
        <div class="col-3">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Form Submit</div></div>
                <!--end::Header-->
                <!--begin::Form-->
                
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="isbn" class="form-label">
                                Note <b class="text-danger">*</b>
                            </label>

                            <textarea type="text" 
                                class="form-control" 
                                name="note" 
                                id="note" 
                                placeholder="Note"></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" id="btn-draft" class="btn btn-success btn-flat btn-sm "><i class="fa fa-save"></i> Draft</button>
                            <button type="submit" id="btn-submit" class="btn btn-primary btn-flat btn-sm float-end"><i class="fa fa-save"></i> Submit</button>&nbsp;
                        </div>
                        

                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <!-- <div class="card-footer">
                      <button type="submit" id="btn-submit" class="btn btn-success btn-flat btn-sm float-end"><i class="fa fa-save"></i> Simpan</button>
                  </div> -->
                    <!--end::Footer-->
                <!--end::Form-->
            </div>  
        </div>
    </div>    
    </form>
</div>
@endsection
@section('js')
<script>
    $(function(){
        $('#uraian').summernote({
            height: 200,
            placeholder: 'Tuliskan uraian tugas harian...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        flatpickr("#tanggal", {
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
            allowInput: false,
            locale: "id",
            defaultDate: "today"
        });

        $("#btn-draft").on('click',function(e){
            e.preventDefault();
            proses_data('draft');
        });

        $("#btn-submit").on('click',function(e){
            e.preventDefault();
            proses_data('submit');
        });
    })
    
    proses_data = function(status){
        let iData =  new FormData($("#form_data")[0]);
        iData.append('status', status);
        var id = $("#id").val();
        $.ajax({
            type    : "POST",
            url     : "{{ route('task.update', ':id') }}".replace(':id', id),
            data    : iData,
            processData: false,
            contentType: false,
            cache   : false,
            beforeSend  : function (){
                $("#btn-submit").html("<i class='fa fa-spinner fa-spin'></i>  Submit..")
                $("#btn-submit").prop("disabled",true);
                $("#btn-draft").html("<i class='fa fa-spinner fa-spin'></i>  Draft..")
                $("#btn-draft").prop("disabled",true);
            },
            success: function(result){
                console.log(result)
                if(result.status == "success"){
                    position = "bottom-left";
                    icons = result.status;
                    pesan = result.messages;
                    title = "Updated!";
                    info(title,pesan,icons,position);
                    $("#btn-submit").html("<i class='fa fa-save'></i> Submit")
                    $("#btn-submit").prop("disabled",false);
                    $("#btn-draft").html("<i class='fa fa-save'></i> Draft")
                    $("#btn-draft").prop("disabled",false);
                    setTimeout(() => {
                        window.location.href = "{{ route('task') }}";
                    }, 2000);
                    
                }
            },
            error: function(e){
                console.log(e)
                $("#btn-submit").html("<i class='fa fa-save'></i> Simpan")
                $("#btn-submit").prop("disabled",false);
                $("#btn-draft").html("<i class='fa fa-save'></i> Draft")
                $("#btn-draft").prop("disabled",false);
                error_message(e,'Server Error!');
            }
        })
    }
    
</script>
@endsection

