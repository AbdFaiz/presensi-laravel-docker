<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $prodis = ProgramStudi::all();

        return view('admin.prodi.index', compact('prodis'));
    }

    public function create()
    {
        return view('admin.prodi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:program_studis',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        ProgramStudi::create($validated);

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi berhasil ditambahkan.');
    }

    public function edit(ProgramStudi $programStudi)
    {
        return view('admin.prodi.edit', ['prodi' => $programStudi]);
    }

    public function update(Request $request, ProgramStudi $programStudi)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:program_studis,kode,'.$programStudi->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $programStudi->update($validated);

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi berhasil diupdate.');
    }

    public function destroy(ProgramStudi $programStudi)
    {
        $programStudi->delete();

        return redirect()->route('admin.prodi.index')->with('success', 'Program Studi berhasil dihapus.');
    }
}
