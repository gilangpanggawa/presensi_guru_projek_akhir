<?php

namespace App\Http\Controllers;

use App\Models\PresensiHadir;
use App\Models\dataguru;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PresensiHadirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Kehadiran';
        $data = DB::table('presensihadir')->join('dataguru', 'dataguru.id_dataguru', '=','presensihadir.id_dataguru')->get();
        return view('presensihadir.index', compact('title', 'data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Form Presensi Kehadiran';
        $data = DB::table('presensihadir')->get();
        return view('presensihadir.create', compact('title', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $guruId = $request->input('id_dataguru');

        $today = Carbon::now()->isoFormat('dddd, D MMMM Y');
        $todayhour = Carbon::now()->isoFormat('HH:mm');
        $currentTime = Carbon::now();
        $limitTimeStart = Carbon::createFromTime(9, 0, 0);
        $limitTimeEnd = Carbon::createFromTime(12, 0, 0);
        $shiftStart = Carbon::createFromTime(12, 0, 0);
        $shiftEnd = Carbon::createFromTime(13, 0, 0);

        // periksa apakah guru telah melakukan presensi pada hari ini
        $presensiHariIni = Presensihadir::where('id_dataguru', $guruId)->where('waktu_presensi_hari', $today)->first();

        if($presensiHariIni){
            return back()->with('gagal', 'Anda Sudah Absensi Hari Ini!!!');
        }else {
            $statusKehadiran = 'Hadir';
            $notifMessage = 'Absensi Berhasil!';

            if ($currentTime->greaterThanOrEqualTo($limitTimeStart) && $currentTime->lessThanOrEqualTo($limitTimeEnd)) {
                // Presensi antara jam 9 dan jam 12
                $statusKehadiran = 'Terlambat';
                $notifMessage = 'Anda Terlambat Absensi!';
            } elseif ($currentTime->greaterThan($limitTimeEnd) && $currentTime->lessThanOrEqualTo($shiftEnd)) {
                // Presensi lebih dari jam 12 sampai jam 1
                $statusKehadiran = 'Hadir (Shift Siang)';
            } elseif ($currentTime->greaterThan($shiftEnd)) {
                // Presensi lebih dari jam 1
                $statusKehadiran = 'Terlambat (Shift Siang)';
                $notifMessage = 'Anda Terlambat Absensi!';
            }

            // Simpan data presensi
            DB::table('presensihadir')->insert([
                'id_dataguru' => $guruId,
                'status_kehadiran' => $statusKehadiran,
                'waktu_presensi_hari' => $today,
                'waktu_presensi_jam' => $todayhour,
            ]);

            return back()->with('sukses', $notifMessage);
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
