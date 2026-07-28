<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\KelasKuliah;
use App\Models\KrsDetail;

class KrsController extends Controller
{
    public function index()
    {
        $mhs = auth()->user()->mahasiswaProfile;
        $krsSaya = KrsDetail::where('mahasiswa_id', $mhs->id)
            ->with(['kelasKuliah.mataKuliah', 'kelasKuliah.dosen'])
            ->get();

        $kelasTersedia = KelasKuliah::with(['mataKuliah', 'dosen'])
            ->whereNotIn('id', $krsSaya->pluck('kelas_kuliah_id'))
            ->get();

        return view('mahasiswa.krs.index', compact('krsSaya', 'kelasTersedia'));
    }

    public function ambil(KelasKuliah $kelasKuliah)
    {
        $mhs = auth()->user()->mahasiswaProfile;

        KrsDetail::create([
            'kelas_kuliah_id' => $kelasKuliah->id,
            'mahasiswa_id' => $mhs->id,
            'status' => 'pending',
        ]);

        return redirect()->route('mhs.krs.index')->with('success', 'Berhasil mengajukan KRS. Menunggu persetujuan admin.');
    }

    public function batal(KrsDetail $krsDetail)
    {
        $mhs = auth()->user()->mahasiswaProfile;

        if ($krsDetail->mahasiswa_id !== $mhs->id) {
            abort(403);
        }

        if ($krsDetail->status === 'pending') {
            $krsDetail->update(['status' => 'dibatalkan']);

            return redirect()->route('mhs.krs.index')->with('success', 'KRS berhasil dibatalkan.');
        }

        return redirect()->route('mhs.krs.index')->with('error', 'Hanya KRS pending yang bisa dibatalkan.');
    }
}
