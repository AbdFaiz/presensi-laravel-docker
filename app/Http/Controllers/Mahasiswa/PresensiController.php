<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use App\Models\KrsDetail;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index()
    {
        $mhs = auth()->user()->mahasiswaProfile;
        $kelasAktifIds = KrsDetail::where('mahasiswa_id', $mhs->id)
            ->where('status', 'aktif')
            ->pluck('kelas_kuliah_id');

        $jadwalAktif = JadwalKuliah::whereIn('kelas_kuliah_id', $kelasAktifIds)
            ->where('status_sesi', 'dibuka')
            ->with('kelasKuliah.mataKuliah')
            ->get();

        $riwayat = Presensi::where('mahasiswa_id', $mhs->id)
            ->with('jadwalKuliah.kelasKuliah.mataKuliah')
            ->latest()
            ->get();

        return view('mahasiswa.presensi.index', compact('jadwalAktif', 'riwayat'));
    }

    public function submit(JadwalKuliah $jadwalKuliah)
    {
        $mhs = auth()->user()->mahasiswaProfile;

        $existing = Presensi::where('jadwal_kuliah_id', $jadwalKuliah->id)
            ->where('mahasiswa_id', $mhs->id)
            ->first();

        if ($existing) {
            return redirect()->route('mhs.presensi.index')->with('error', 'Anda sudah melakukan presensi untuk sesi ini.');
        }

        $validated = request()->validate([
            'status' => 'required|in:hadir,izin,sakit',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Presensi::create([
            'jadwal_kuliah_id' => $jadwalKuliah->id,
            'mahasiswa_id' => $mhs->id,
            'waktu_presensi' => now(),
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'] ?? null,
        ]);

        return redirect()->route('mhs.presensi.index')->with('success', 'Presensi berhasil dikirim.');
    }
}
