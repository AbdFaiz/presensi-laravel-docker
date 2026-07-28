<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KrsDetail;

class KrsDetailController extends Controller
{
    public function index()
    {
        $krs = KrsDetail::with(['mahasiswa', 'kelasKuliah.mataKuliah', 'kelasKuliah.dosen'])->get();

        return view('admin.krs.index', compact('krs'));
    }

    public function approve(KrsDetail $krsDetail)
    {
        $krsDetail->update([
            'status' => 'aktif',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.krs.index')->with('success', 'KRS berhasil disetujui.');
    }

    public function reject(KrsDetail $krsDetail)
    {
        $krsDetail->update([
            'status' => 'ditolak',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('admin.krs.index')->with('success', 'KRS berhasil ditolak.');
    }
}
