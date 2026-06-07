@extends('layouts.app')
@section('title','Lihat Data Tugas Harian')
@section('breadcrumb')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6"><h5 class="mb-2">Lihat Data Tugas Harian</h5></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('task') }}">Data Tugas Harian</a></li>
            <li class="breadcrumb-item active" aria-current="page">Lihat</li>
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
                <div class="card-header"><div class="card-title">Lihat Data Tugas Harian</div></div>
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
                            disabled="disabled"
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
                            value="{{ Carbon\Carbon::parse($data->tanggal)->locale('id')->translatedFormat('d F Y') }}"
                            disabled="disabled"
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
                            disabled="disabled"
                            placeholder="Uraian">{{ $data->uraian }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="dokumentasi" class="form-label">
                            Dokumentasi 
                        </label>
                        @if(empty($data->dokumentasi))
                            Tidak ada dokumentasi
                        @else
                            <img src="/uploads/images/{{ $data->dokumentasi }}" class="img-responsive" style='max-width:100%'>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                      <a href="{{ route('task') }}" class="btn btn-danger btn-flat btn-sm"><i class="fa fa-mail-reply"></i> Kembali</a>
                  </div>
                <!--end::Form-->
            </div>  
        </div>
        <div class="col-4">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Log Approval</div></div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($logs as $label)
                            <div class="time-label"><span class="text-bg-primary">{{ $label['tanggal_format']}}</span></div>
                            <!-- /.timeline-label -->
                             @foreach($label['items'] as $log)
                                <div>
                                    <i class="timeline-icon bi bi-chat-text-fill text-bg-primary"></i>
                                    <div class="timeline-item">
                                    <span class="time"> <i class="bi bi-clock-fill"></i> {{ $log['jam'] }} </span>
                                    <h3 class="timeline-header no-border">
                                        <a href="#">{{ $log['nama_pegawai'] }}</a>
                                    </h3>
                                    <div class="timeline-body">
                                        {{ $log['note'] }}
                                    </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- END timeline item -->
                            <!-- timeline time label -->
                        @endforeach
                        @if($data->status != "posted")
                            <div><i class="timeline-icon bi bi-clock-fill text-bg-secondary"></i></div>
                        @else
                            <div><i class="timeline-icon fa fa-check-square text-bg-success"></i></div>
                        @endif
                    </div>
                </div>
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
         $('#uraian').summernote('disable');

    })
    
</script>
@endsection

