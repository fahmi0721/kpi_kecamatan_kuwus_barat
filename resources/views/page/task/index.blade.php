@extends('layouts.app')
@section('title','Tugas Harian Pegawai')
@section('breadcrumb')
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
    <!--begin::Row-->
    <div class="row">
        <div class="col-sm-6"><h5 class="mb-2">Tugas Harian Pegawai</h5></div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tugas Harian Pegawai</li>
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
        <div class="col-12">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header d-flex  align-items-center">
                    <h5 class="mb-0">Data Tugas Harian Pegawai</h5>
                </div>
                <div class="card-body">
                    <table id="tb_data" class="table table-bordered table-striped dt-responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th width='5%'>No</th>
                                @if(auth()->user()->level != "pegawai")
                                <th>Pegawai</th>
                                @endif
                                <th>Judul</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Uraian</th>
                                <th>Dokumentasi</th>
                                <th width='5%'>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>  
        </div>
    </div>    
</div>
@endsection
@section('js')
<script>
$(document).ready(function() {
    load_data();
});
function hapusData(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data ini akan dihapus secara permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('task.delete', ':id') }}".replace(':id', id),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: "DELETE"
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'Data berhasil dihapus.',
                        'success'
                    );
                    // Reload DataTable
                    $('#tb_data').DataTable().ajax.reload();
                },
                error: function(err) {
                    console.log(err);
                    Swal.fire(
                        'Gagal!',
                        'Terjadi kesalahan saat menghapus data.',
                        'error'
                    );
                }
            });
        }
    });
}
load_data = function(){
    $('#tb_data').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('task') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable:false,orderable:false},
            @if(auth()->user()->level != "pegawai")
            { data: 'pegawai', name: 'pegawai' },
            @endif
            { data: 'judul', name: 'judul' },
            { data: 'tanggal', name: 'tanggal' },
            { data: 'status', name: 'status' },
            { data: 'uraian', name: 'uraian' },
            { data: 'dokumentasi', name: 'dokumentasi',searchable:false,orderable:false },
            { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
        ]
    });
}
</script>
@endsection

