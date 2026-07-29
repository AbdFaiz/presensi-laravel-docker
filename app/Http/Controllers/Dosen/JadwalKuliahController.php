<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;

class JadwalKuliahController extends Controller
{
    public function index()
    {
        $dosen = auth()->user()->dosenProfile;
        $kelasIds = $dosen->kelasKuliahs()->pluck('kelas_kuliahs.id');
        $jadwals = JadwalKuliah::whereIn('kelas_kuliah_id', $kelasIds)
            ->with('kelasKuliah.mataKuliah')
            ->withCount('presensis')
            ->get();

        $mhsCounts = \App\Models\KrsDetail::where('status', 'aktif')
            ->whereIn('kelas_kuliah_id', $kelasIds)
            ->selectRaw('kelas_kuliah_id, count(*) as total')
            ->groupBy('kelas_kuliah_id')
            ->pluck('total', 'kelas_kuliah_id');

        foreach ($jadwals as $j) {
            $j->total_mahasiswa = $mhsCounts[$j->kelas_kuliah_id] ?? 0;
        }

        return view('dosen.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $dosen = auth()->user()->dosenProfile;
        $kelas = $dosen->kelasKuliahs;

        return view('dosen.jadwal.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_kuliah_id' => 'required|exists:kelas_kuliahs,id',
            'pertemuan_ke' => 'required|integer|min:1|max:16',
            'tgl_pertemuan' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $validated['status_sesi'] = 'ditutup';

        JadwalKuliah::create($validated);

        return redirect()->route('dosen.jadwal.index')->with('success', 'Jadwal pertemuan berhasil ditambahkan.');
    }

    public function toggle(JadwalKuliah $jadwalKuliah)
    {
        $newStatus = $jadwalKuliah->status_sesi === 'dibuka' ? 'ditutup' : 'dibuka';
        $jadwalKuliah->update(['status_sesi' => $newStatus]);

        $msg = $newStatus === 'ditutup' ? 'Sesi presensi berhasil ditutup.' : 'Sesi presensi berhasil dibuka.';

        return redirect()->route('dosen.jadwal.index')->with('success', $msg);
    }
}
