<?php

namespace App\Services;

use App\Models\Task;
use App\Models\LogApproval;
use App\Models\ViewPegawaiBawahan;
use App\Models\ViewLogApprovalTimeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Validator;

class TaskService
{
    public static function get_all_data(){
        if(Auth::user()->level == "pegawai"){
            $data = Task::get_all_data()
                    ->where("pegawai_id", Auth::user()->pegawai_id);
        }elseif(Auth::user()->level == "pimpinan"){
            $pegawai_ids = self::get_pegawai_id_bawahan();
            $pegawai_ids[] = Auth::user()->pegawai_id;
            $data = Task::get_all_data()
                    ->whereIn("pegawai_id", $pegawai_ids);
        }else{
            $data = Task::get_all_data();
        }
        
        return $data;
    }

    public static function get_count_task(){
        $user = Auth::user();
        $query = Task::query();
        if ($user->level === 'pegawai') {
            // hanya data pegawai login
            $query->where('pegawai_id', $user->pegawai_id);
        } elseif ($user->level === 'pimpinan') {
            // ambil pegawai bawahan
            $pegawai_ids = ViewPegawaiBawahan::where('pegawai_atasan_id', $user->pegawai_id)
                ->pluck('pegawai_bawahan_id')
                ->toArray();
            // tambahkan dirinya sendiri
            $pegawai_ids[] = $user->pegawai_id;
            $query->whereIn('pegawai_id', $pegawai_ids);
        }

        $jumlahTask = $query->selectRaw("
                CASE 
                    WHEN status = 'posted' THEN 'selesai'
                    WHEN status IN ('draft', 'submit', 'reject') THEN 'pending'
                    ELSE 'pending'
                END as kategori,
                COUNT(*) as total
            ")
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $summary = [
            'selesai' => $jumlahTask['selesai'] ?? 0,
            'pending' => $jumlahTask['pending'] ?? 0,
        ];
        return $summary;
    }

    public static function chartTaskPosted()
    {
        $user = Auth::user();

        $query = Task::query()
            ->where('status', 'posted');

        if ($user->level === 'pegawai') {

            // hanya data pegawai login
            $query->where('pegawai_id', $user->pegawai_id);

        } elseif ($user->level === 'pimpinan') {

            // data bawahan + data sendiri
            $pegawai_ids = ViewPegawaiBawahan::where('pegawai_atasan_id', $user->pegawai_id)
                ->pluck('pegawai_bawahan_id')
                ->toArray();

            $pegawai_ids[] = $user->pegawai_id;

            $query->whereIn('pegawai_id', $pegawai_ids);
        }

        $data = $query->selectRaw('DATE(tanggal) as tanggal, COUNT(*) as total')
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        return [
            'status' => 'success',
            'labels' => $data->pluck('tanggal'),
            'values' => $data->pluck('total'),
        ];
    }

    private static function get_pegawai_id_bawahan(){
        return ViewPegawaiBawahan::where("pegawai_atasan_id",Auth::user()->pegawai_id)
                ->pluck('pegawai_bawahan_id')
                ->toArray();

    }
    public static function cek_bawahan_langsung($pegawai_bawahan_id){
        return ViewPegawaiBawahan::where("pegawai_bawahan_id",$pegawai_bawahan_id)
                ->where("pegawai_atasan_id",Auth::user()->pegawai_id)
                ->where("level",1)
                ->exists();
    }

    public static function get_data_by_id($id){
        $data = Task::findOrFail($id);
        return $data;
    }

    public static function getAtasanLangsing($tugas_id){
        return  ViewLogApprovalTimeline::get_all_data()->where("tugas_id",$tugas_id)->orderBy("created_at","desc")->first();
    }

    public static function getTimelineByTugas($tugas_id)
    {
        $logs = ViewLogApprovalTimeline::where('tugas_id', $tugas_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return $logs->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m-d');
        })->map(function ($items, $tanggal) {
            return [
                'tanggal' => $tanggal,
                'tanggal_format' => Carbon::parse($tanggal)
                    ->locale('id')
                    ->translatedFormat('d F Y'),
                'items' => $items->map(function ($log) {
                    return [
                        'log_id' => $log->log_id,
                        'tugas_id' => $log->tugas_id,
                        'pegawai_id' => $log->pegawai_id,
                        'nama_pegawai' => $log->nama_pegawai,
                        'note' => $log->notes,
                        'jam' => Carbon::parse($log->created_at)->format('H:i'),
                        'created_at' => $log->created_at,
                    ];
                })->values()
            ];
        })->values();
    }

    public static function Validasi($request,$aksi=null){
        $validates = [
            'judul'  => 'required',
            'tanggal'  => 'required',
            'uraian'  => 'required',
            'note'  => 'required',
        ];

        $messages = [
            'judul.required'  => 'Judul Tugas wajib diisi.',
            'tanggal.required'  => 'Tanggal Tugas wajib diisi.',
            'uraian.required'  => 'Uraian Tugas wajib diisi.',
            'note.required'  => 'Note wajib diisi.',
        ];
        if($aksi == "create"){
            $validates += [
                'dokumentasi' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ];
            $messages += [
                'dokumentasi.required'  => 'Dokumentasi Tugas wajib diisi.',
                'dokumentasi.image'  => 'Dokumentasi Tugas hasru gambar.',
                'dokumentasi.mimes'  => 'Dokumentasi gambar yang dimasukkan bertipe tidak dizinkan, masukkan yang bertipe jpg,jpeg,png',
                'dokumentasi.max'  => 'Dokumentasi Tugas maksimal 2048 kb.',
            ];
        }else{
            if ($request->hasFile('dokumentasi') && $request->file('dokumentasi')->isValid()) {
                $validates += [
                    'dokumentasi' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                ];
                $messages += [
                    'dokumentasi.required'  => 'Dokumentasi Tugas wajib diisi.',
                    'dokumentasi.image'  => 'Dokumentasi Tugas hasru gambar.',
                    'dokumentasi.mimes'  => 'Dokumentasi gambar yang dimasukkan bertipe tidak dizinkan, masukkan yang bertipe jpg,jpeg,png',
                    'dokumentasi.max'  => 'Dokumentasi Tugas maksimal 2048 kb.',
                ];
            }
        }
        $request->validate($validates, $messages);
    }

    public static function ValidasiApprove($request,$aksi=null){
        $validates = [
            'id'  => 'required',
            'status'  => 'required',
            'note'  => 'required',
        ];

        $messages = [
            'id.required'  => 'ID Tugas tidak ditemukan.',
            'status.required'  => 'Status Tugas ditemukan.',
            'note.required'  => 'Note wajib diisi.',
        ];
        
        $request->validate($validates, $messages);
    }

    public static function Save($request)
    {
        return DB::transaction(function () use ($request) {
            $pegawai_id = Auth::user()->pegawai_id;
            $data = array(
                'judul'  => $request->judul,
                'tanggal'  => $request->tanggal,
                'uraian'  => $request->uraian,
                'status'  => $request->status,
                'pegawai_id'  => $pegawai_id
            );
            $dokumentasi = $request->file('dokumentasi');
            if ($request->hasFile('dokumentasi') && $request->file('dokumentasi')->isValid()) {
                $path = public_path('uploads/images/');
                $dokumentasiname = uniqid() . '.' . $dokumentasi->getClientOriginalExtension();
                $dokumentasi->move($path,$dokumentasiname);
                $data += ['dokumentasi' => $dokumentasiname];
            }
            $task = Task::create($data);
            if($task){
                $logs = array(
                    "tugas_id" => $task->id,
                    "notes" => $request->note,
                    'pegawai_id'  => $pegawai_id
                );
                if(LogApproval::create($logs)){
                    return true;
                }
                                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function Update($request)
    {
        return DB::transaction(function () use ($request) {
            $pegawai_id = Auth::user()->pegawai_id;
            $data = array(
                'judul'  => $request->judul,
                'tanggal'  => $request->tanggal,
                'uraian'  => $request->uraian,
                'status'  => $request->status,
            );
            $dokumentasi = $request->file('dokumentasi');
            if ($request->hasFile('dokumentasi') && $request->file('dokumentasi')->isValid()) {
                $path = public_path('uploads/images/');
                $dokumentasiname = uniqid() . '.' . $dokumentasi->getClientOriginalExtension();
                $dokumentasi->move($path,$dokumentasiname);
                $data += ['dokumentasi' => $dokumentasiname];
            }
            if(Task::findOrFail($request->id)->update($data)){
                $logs = array(
                    "tugas_id" => $request->id,
                    "notes" => $request->note,
                    'pegawai_id'  => $pegawai_id
                );
                if(LogApproval::create($logs)){
                    return true;
                }
                             
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function update_approve($request)
    {
        return DB::transaction(function () use ($request) {
            $pegawai_id = Auth::user()->pegawai_id;
            $data = array(
                'status'  => $request->status,
            );
            if(Task::findOrFail($request->id)->update($data)){
                $logs = array(
                    "tugas_id" => $request->id,
                    "notes" => $request->note,
                    'pegawai_id'  => $pegawai_id
                );
                if(LogApproval::create($logs)){
                    return true;
                }
                             
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    public static function Delete($id)
    {
        return DB::transaction(function () use ($id) {
            if(Task::findOrFail($id)->delete()){
                return true;                
            }
            throw new Exception("Terjadi kesalahan sistem");
        });
    }

    
}
