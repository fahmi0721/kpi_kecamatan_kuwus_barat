<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Services\PegawaiService;
// use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

    public function get_count(){
        $data = TaskService::get_count_task();
        $data['pegawai'] = PegawaiService::get_count();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    public function get_barchar(){
        $data = TaskService::chartTaskPosted();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }
    
}
