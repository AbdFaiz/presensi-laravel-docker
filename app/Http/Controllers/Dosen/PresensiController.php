<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function show(JadwalKuliah $jadwalKuliah)
    {
        $dosen = auth()->user()->dosenProfile;

        if ($jadwalKuliah->kelasKuliah->dosen_id !== $dosen->id) {
            abort(403);
        }

        $presensis = $jadwalKuliah->presensis()
            ->with('mahasiswa.user')
            ->get()
            ->keyBy('mahasiswa_id');

        $mahasiswas = \App\Models\KrsDetail::where('status', 'aktif')
            ->where('kelas_kuliah_id', $jadwalKuliah->kelas_kuliah_id)
            ->with('mahasiswa.user')
            ->get()
            ->pluck('mahasiswa');

        return view('dosen.presensi.show', compact('jadwalKuliah', 'presensis', 'mahasiswas'));
    }

    public function export(JadwalKuliah $jadwalKuliah)
    {
        $dosen = auth()->user()->dosenProfile;

        if ($jadwalKuliah->kelasKuliah->dosen_id !== $dosen->id) {
            abort(403);
        }

        $presensis = $jadwalKuliah->presensis()
            ->with('mahasiswa.user')
            ->get()
            ->keyBy('mahasiswa_id');

        $mahasiswas = \App\Models\KrsDetail::where('status', 'aktif')
            ->where('kelas_kuliah_id', $jadwalKuliah->kelas_kuliah_id)
            ->with('mahasiswa.user')
            ->get()
            ->pluck('mahasiswa');

        $filename = 'presensi-' . $jadwalKuliah->kelasKuliah->mataKuliah->nama_mk . '-pertemuan-' . $jadwalKuliah->pertemuan_ke . '.csv';
        $filename = str_replace(['/', '\\', ' ', ':'], '-', $filename);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($mahasiswas, $presensis, $jadwalKuliah) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['No', 'NIM', 'Nama', 'Status', 'Waktu Presensi', 'Keterangan']);

            $no = 1;
            foreach ($mahasiswas as $mhs) {
                $p = $presensis->get($mhs->id);
                fputcsv($handle, [
                    $no++,
                    $mhs->nim,
                    $mhs->nama_lengkap,
                    $p ? ucfirst($p->status) : 'Alfa',
                    $p && $p->waktu_presensi ? $p->waktu_presensi->format('H:i d/m/Y') : '-',
                    $p->keterangan ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
