<?php

namespace App\Http\Controllers;

use App\Models\dataguru;
use App\Models\PresensiHadir;
use App\Models\PresensiPulang;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');

        $dataguru = DB::table('dataguru')->count();
        $presensihadir = DB::table('presensihadir')->where('waktu_presensi_hari', $today)->count();
        $presensipulang = DB::table('presensipulang')->where('waktu_presensi_hari', $today)->count();

        return view('dashboard.index', compact('dataguru', 'presensihadir', 'presensipulang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
