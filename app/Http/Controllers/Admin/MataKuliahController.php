<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $matkuls = MataKuliah::with('programStudi')->get();
        return view('admin.mk.index', compact('matkuls'));
    }

    public function create()
    {
        $prodis = ProgramStudi::all();
        return view('admin.mk.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliahs',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        MataKuliah::create($validated);

        return redirect()->route('admin.mk.index')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        $prodis = ProgramStudi::all();
        return view('admin.mk.edit', ['mk' => $mataKuliah, 'prodis' => $prodis]);
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliahs,kode_mk,' . $mataKuliah->id,
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
            'program_studi_id' => 'required|exists:program_studis,id',
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('admin.mk.index')->with('success', 'Mata Kuliah berhasil diupdate.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return redirect()->route('admin.mk.index')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
