<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\KelasKuliah;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class KelasKuliahController extends Controller
{
    public function index()
    {
        $kelases = KelasKuliah::with(['mataKuliah', 'dosen'])->get();
        return view('admin.kelas.index', compact('kelases'));
    }

    public function create()
    {
        $matkuls = MataKuliah::all();
        $dosens = Dosen::all();
        return view('admin.kelas.create', compact('matkuls', 'dosens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'nama_kelas' => 'required|string|max:50',
            'tahun_akademik' => 'required|string|max:20',
        ]);

        KelasKuliah::create($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(KelasKuliah $kelasKuliah)
    {
        $matkuls = MataKuliah::all();
        $dosens = Dosen::all();
        return view('admin.kelas.edit', ['kelas' => $kelasKuliah, 'matkuls' => $matkuls, 'dosens' => $dosens]);
    }

    public function update(Request $request, KelasKuliah $kelasKuliah)
    {
        $validated = $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'dosen_id' => 'required|exists:dosens,id',
            'nama_kelas' => 'required|string|max:50',
            'tahun_akademik' => 'required|string|max:20',
        ]);

        $kelasKuliah->update($validated);

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate.');
    }

    public function destroy(KelasKuliah $kelasKuliah)
    {
        $kelasKuliah->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
