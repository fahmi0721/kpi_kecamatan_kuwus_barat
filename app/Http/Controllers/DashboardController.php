<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BukuService;
// use Illuminate\Support\Facades\DB;
// use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard');
    }

    
}
