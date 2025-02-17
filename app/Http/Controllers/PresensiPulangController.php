<?php

namespace App\Http\Controllers;

use App\Models\PresensiPulang;
use App\Models\dataguru;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresensiPulangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Kepulangan';
        $data = DB::table('presensipulang')->join('dataguru', 'dataguru.id_dataguru', '=','presensipulang.id_dataguru')->get();
        return view('presensipulang.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Presensi Pulang';
        $data = DB::table('presensipulang')->get();
        return view('presensipulang.create', compact('title', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $guruId = $request->input('id_dataguru');

        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $todayhour = Carbon::now()->isoFormat('HH:mm');

        // periksa apakah guru telah melakukan presensi pada hari ini
        $presensiHariIni = Presensipulang::where('id_dataguru', $guruId)->where('waktu_presensi_hari', $today)->first();

        if($presensiHariIni){
            return back()->with('gagal', 'Anda Sudah Absensi Hari Ini!!!');
        }else{
            // Jika guru belum melakukan presensi hari ini
            DB::table('presensipulang')->insert([
                'id_dataguru' => $guruId,
                'status_kepulangan' => 'Berhasil',
                'waktu_presensi_hari' => $today,
                'waktu_presensi_jam' => $todayhour,
            ]);

            return back()->with('sukses', 'Absensi Berhasil!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
