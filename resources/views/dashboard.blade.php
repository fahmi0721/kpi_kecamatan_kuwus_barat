@extends('layouts.app')

@section('title','Dashboard Keuangan')

@section('css')

@endsection

@section('content')
<div class="container-fluid">
    <div class="mb-3 align-items-center mt-4">
    <center><h4 class="mb-0">SISTEM INFORMASI MONITORING KINERJA (SiMoKin KWB)</h4> <h5>PADA KECAMATAN KECAMATAN KUWUS BARAT KABUPATEN MANGGARAI BARAT</h5>
  
</div>
<div class="container-fluid">
<div class="row">
    <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
        <span class="info-box-icon text-bg-primary shadow-sm">
        <i class="fa fa-users"></i>
        </span>
        <div class="info-box-content">
        <span class="info-box-text">Jumlah Pegawai</span>
        <span class="info-box-number">
            <span id="total-pegawai"></span>
        </span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
        <span class="info-box-icon text-bg-success shadow-sm">
        <i class="fa fa-clipboard-list"></i>
        </span>
        <div class="info-box-content">
        <span class="info-box-text">Jumlah Tugas Selesai</span>
        <span class="info-box-number"><span id="total-selesai"></span></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <!-- fix for small devices only -->
    <!-- <div class="clearfix hidden-md-up"></div> -->
    <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
        <span class="info-box-icon text-bg-warning shadow-sm">
        <i class="fa fa-list"></i>
        </span>
        <div class="info-box-content">
        <span class="info-box-text">Sumlah Tugas Pending</span>
        <span class="info-box-number"><span id="total-pending"></span></span>
        </div>
        <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Grafik Task Selesai</h5>
            </div>
            <div class="card-body">
                <canvas id="chartTaskPosted" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script>
    let chartTaskPosted = null;
    $(document).ready(function () {
        getTaskSummary();
        getChartTaskPosted();
    });



    function getChartTaskPosted() {
        $.ajax({
            type: "GET",
            url: "{{ route('dashboard.chart-task-posted') }}",
            dataType: "json",
            beforeSend: function () {
                console.log("Mengambil data chart...");
            },
            success: function (result) {
                console.log(result)
                if (result.status === "success") {
                    renderChartTaskPosted(result.data.labels, result.data.values);
                }
            },
            error: function (xhr) {
                console.log(xhr);
                alert("Gagal mengambil data chart task posted");
            }
        });
    }

    function renderChartTaskPosted(labels, values) {
        const ctx = document.getElementById('chartTaskPosted').getContext('2d');

        if (chartTaskPosted !== null) {
            chartTaskPosted.destroy();
        }

        chartTaskPosted = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Task Selesai',
                    data: values,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: false,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        title: {
                            display: true,
                            text: 'Jumlah Task'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    }
                }
            }
        });
    }
    function getTaskSummary() {
        $.ajax({
            type: "GET",
            url: "{{ route('dashboard.task-summary') }}",
            dataType: "json",
            beforeSend: function () {
                $("#total-selesai").html("<i class='fa fa-spinner fa-spin'></i>");
                $("#total-pending").html("<i class='fa fa-spinner fa-spin'></i>");
                $("#total-pegawai").html("<i class='fa fa-spinner fa-spin'></i>");
            },
            success: function (result) {
                console.log(result);
                if (result.status === "success") {
                    $("#total-selesai").html(result.data.selesai);
                    $("#total-pending").html(result.data.pending);
                    $("#total-pegawai").html(result.data.pegawai);
                    
                }
            },
            error: function (xhr) {
                console.log(xhr);

                $("#total-selesai").text("0");
                $("#total-pending").text("0");
                $("#total-pegawai").text("0");

                alert("Gagal mengambil data summary task");
            }
        });
    }
</script>
@endsection
