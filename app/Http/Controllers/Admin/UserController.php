<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['dosenProfile', 'mahasiswaProfile'])->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $prodis = \App\Models\ProgramStudi::orderBy('nama')->get();

        return view('admin.users.create', compact('prodis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,dosen,mahasiswa',
            'nip' => 'nullable|required_if:role,dosen|string|max:255|unique:dosens,nip',
            'nim' => 'nullable|required_if:role,mahasiswa|string|max:255|unique:mahasiswas,nim',
            'nama_lengkap' => 'nullable|required_if:role,dosen|required_if:role,mahasiswa|string|max:255',
            'program_studi_id' => 'nullable|required_if:role,dosen|required_if:role,mahasiswa|exists:program_studis,id',
            'angkatan' => 'nullable|required_if:role,mahasiswa|integer|min:2000|max:2100',
            'gelar' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $user = User::create($validated);

        if ($validated['role'] === 'dosen') {
            $user->dosenProfile()->create([
                'nip' => $validated['nip'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'program_studi_id' => $validated['program_studi_id'],
                'gelar' => $validated['gelar'] ?? null,
                'no_hp' => $validated['no_hp'] ?? null,
            ]);
        }

        if ($validated['role'] === 'mahasiswa') {
            $user->mahasiswaProfile()->create([
                'nim' => $validated['nim'],
                'nama_lengkap' => $validated['nama_lengkap'],
                'program_studi_id' => $validated['program_studi_id'],
                'angkatan' => $validated['angkatan'],
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $user->load(['dosenProfile', 'mahasiswaProfile']);
        $prodis = \App\Models\ProgramStudi::orderBy('nama')->get();

        return view('admin.users.create', compact('user', 'prodis'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,dosen,mahasiswa',
            'nip' => 'nullable|string|max:255|unique:dosens,nip,'.($user->dosenProfile?->id ?? 'NULL').',id',
            'nim' => 'nullable|string|max:255|unique:mahasiswas,nim,'.($user->mahasiswaProfile?->id ?? 'NULL').',id',
            'nama_lengkap' => 'nullable|string|max:255',
            'program_studi_id' => 'nullable|exists:program_studis,id',
            'angkatan' => 'nullable|integer|min:2000|max:2100',
            'gelar' => 'nullable|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        if ($validated['role'] === 'dosen') {
            $profile = $user->dosenProfile;
            if ($profile) {
                $profile->update([
                    'nip' => $validated['nip'],
                    'nama_lengkap' => $validated['nama_lengkap'] ?? $user->name,
                    'program_studi_id' => $validated['program_studi_id'],
                    'gelar' => $validated['gelar'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                ]);
            } else {
                $user->dosenProfile()->create([
                    'nip' => $validated['nip'],
                    'nama_lengkap' => $validated['nama_lengkap'] ?? $user->name,
                    'program_studi_id' => $validated['program_studi_id'],
                    'gelar' => $validated['gelar'] ?? null,
                    'no_hp' => $validated['no_hp'] ?? null,
                ]);
            }

            if ($user->mahasiswaProfile) {
                $user->mahasiswaProfile->delete();
            }
        } elseif ($validated['role'] === 'mahasiswa') {
            $profile = $user->mahasiswaProfile;
            if ($profile) {
                $profile->update([
                    'nim' => $validated['nim'],
                    'nama_lengkap' => $validated['nama_lengkap'] ?? $user->name,
                    'program_studi_id' => $validated['program_studi_id'],
                    'angkatan' => $validated['angkatan'],
                ]);
            } else {
                $user->mahasiswaProfile()->create([
                    'nim' => $validated['nim'],
                    'nama_lengkap' => $validated['nama_lengkap'] ?? $user->name,
                    'program_studi_id' => $validated['program_studi_id'],
                    'angkatan' => $validated['angkatan'],
                ]);
            }

            if ($user->dosenProfile) {
                $user->dosenProfile->delete();
            }
        } else {
            $user->dosenProfile()?->delete();
            $user->mahasiswaProfile()?->delete();
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
