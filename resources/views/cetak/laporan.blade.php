<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Harian</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .kop {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop table {
            width: 100%;
        }

        .kop-logo {
            width: 80px;
            text-align: center;
        }

        .kop-logo img {
            width: 70px;
            height: auto;
        }

        .kop-text {
            text-align: center;
            line-height: 1.4;
        }

        .kop-text h3,
        .kop-text h4,
        .kop-text p {
            margin: 0;
            padding: 0;
        }

        .judul {
            text-align: center;
            margin-top: 15px;
            margin-bottom: 20px;
            font-weight: bold;
            text-decoration: underline;
            font-size: 15px;
        }

        .table-info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-info td {
            padding: 5px;
            vertical-align: top;
        }

        .label {
            width: 140px;
        }

        .isi-laporan {
            border: 1px solid #000;
            padding: 10px;
            min-height: 120px;
            margin-bottom: 20px;
        }

        .table-log {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-log th,
        .table-log td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        .table-log th {
            background-color: #eee;
            text-align: center;
        }

        .ttd {
            width: 100%;
            margin-top: 40px;
        }

        .ttd td {
            width: 50%;
            text-align: center;
            vertical-align: top;
        }

        .nama-ttd {
            margin-top: 10px;
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="kop">
        <table>
            <tr>
                <td class="kop-logo">
                    <img src="logo.png">
                </td>
                <td class="kop-text">
                    <h3>PEMERINTAH KABUPATEN MANGGARAI BARAT</h3>
                    <h4>KECAMATAN KUWUS BARAT</h4>
                    
                </td>
            </tr>
        </table>
    </div>

    <div class="judul">
        LAPORAN KINERJA HARIAN
    </div>

    <table class="table-info">
        <tr>
            <td class="label">Nama Pegawai</td>
            <td width="10">:</td>
            <td>{{ $data->pegawai->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>:</td>
            <td>{{ $data->pegawai->nip ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $data->pegawai->jabatan->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>
                {{ \Carbon\Carbon::parse($data->tanggal)->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td>Status</td>
            <td>:</td>
            <td>{{ strtoupper($data->status) }}</td>
        </tr>
    </table>

    <strong>Uraian Tugas:</strong>

    <div class="isi-laporan">
        {!! $data->uraian !!}
    </div>
    <strong>Dokumentasi</strong>

    <div class="isi-laporan">
        <center><img src="uploads/images/{{ $data->dokumentasi }}" style='width:100px;height:100px'></center>
    </div>

    @if(isset($logs) && count($logs) > 0)
        <strong>Log Approval:</strong>

        <table class="table-log">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Tanggal</th>
                    <th width="20%">Jam</th>
                    <th width="25%">Pegawai</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp

                @foreach($logs as $group)
                    @foreach($group['items'] as $log)
                        <tr>
                            <td align="center">{{ $no++ }}</td>
                            <td>{{ $group['tanggal_format'] }}</td>
                            <td>{{ $log['jam'] }}</td>
                            <td>{{ $log['nama_pegawai'] ?? '-' }}</td>
                            <td>{{ $log['note'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @endif

    <table class="ttd">
        <tr>
            <td>
                Mengetahui,<br>
                {{ $atasan_langsung->pegawai->jabatan->nama }}
                <br><br>
                <img src="data:image/svg+xml;base64,{{ $qrcode }}" width="90">
                    
                 <div style="font-size: 10px; margin-top: 5px;">
                    Scan untuk verifikasi
                </div>
                <div class="nama-ttd">
                    {{ $atasan_langsung->pegawai->nama }}
                </div>
                <div>
                    NIP. {{ $atasan_langsung->pegawai->nip }}
                </div>
            </td>

            <td>
                Kuwus Barat,
                {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}
                <br>
                {{ $data->pegawai->jabatan->nama ?? '................................' }}
                <br><br>
                <img src="data:image/svg+xml;base64,{{ $qrcode }}" width="90">
                 <div style="font-size: 10px; margin-top: 5px;">
                    Scan untuk verifikasi
                </div>
                <div class="nama-ttd">
                    {{ $data->pegawai->nama ?? '................................' }}
                </div>
                <div>
                    NIP. {{ $data->pegawai->nip ?? '................................' }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>