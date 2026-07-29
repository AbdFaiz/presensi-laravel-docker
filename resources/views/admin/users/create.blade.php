<x-layouts::app :title="__('Tambah / Edit User')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-3xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ isset($user) ? 'Ubah data pengguna' : 'Buat akun baru untuk pengguna' }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}">
            @csrf
            @isset($user) @method('PUT') @endisset

            <div class="space-y-6">
                <div class="card-unas">
                    <div class="px-8 py-6 space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                            <span class="flex size-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                                <flux:icon.user class="size-4" />
                            </span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Akun</h2>
                                <p class="text-xs text-slate-500">Informasi login pengguna</p>
                            </div>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <flux:input name="name" label="Nama Lengkap" :value="old('name', $user->name ?? '')" required />
                            <flux:input name="username" label="Username" :value="old('username', $user->username ?? '')" required />
                        </div>
                        <flux:input name="email" label="Email" type="email" :value="old('email', $user->email ?? '')" required />
                        <div class="grid gap-5 sm:grid-cols-2">
                            <flux:input name="password" label="{{ isset($user) ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password' }}" type="password" {{ isset($user) ? '' : 'required' }} />
                            <flux:input name="password_confirmation" label="Konfirmasi Password" type="password" {{ isset($user) ? '' : 'required' }} />
                        </div>
                        <flux:select name="role" label="Role" id="role-select" required>
                            <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dosen" {{ old('role', $user->role ?? '') == 'dosen' ? 'selected' : '' }}>Dosen</option>
                            <option value="mahasiswa" {{ old('role', $user->role ?? '') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </flux:select>
                    </div>
                </div>

                <div id="dosen-section" class="card-unas hidden">
                    <div class="px-8 py-6 space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                            <span class="flex size-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400">
                                <flux:icon.academic-cap class="size-4" />
                            </span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Data Dosen</h2>
                                <p class="text-xs text-slate-500">NIP dan informasi dosen pengampu</p>
                            </div>
                        </div>

                        <flux:input name="nip" label="NIP" :value="old('nip', $user->dosenProfile->nip ?? '')" />
                        <flux:input name="nama_lengkap" label="Nama Lengkap" :value="old('nama_lengkap', $user->dosenProfile->nama_lengkap ?? '')" />
                        <flux:select name="program_studi_id" label="Program Studi">
                            <option value="">Pilih Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('program_studi_id', $user->dosenProfile->program_studi_id ?? '') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama }} ({{ $prodi->kode }})</option>
                            @endforeach
                        </flux:select>
                        <div class="grid gap-5 sm:grid-cols-2">
                            <flux:input name="gelar" label="Gelar" :value="old('gelar', $user->dosenProfile->gelar ?? '')" />
                            <flux:input name="no_hp" label="No. HP" :value="old('no_hp', $user->dosenProfile->no_hp ?? '')" />
                        </div>
                    </div>
                </div>

                <div id="mahasiswa-section" class="card-unas hidden">
                    <div class="px-8 py-6 space-y-5">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-200 dark:border-slate-800">
                            <span class="flex size-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-slate-800/50 dark:text-blue-400">
                                <flux:icon.user-group class="size-4" />
                            </span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900 dark:text-white">Data Mahasiswa</h2>
                                <p class="text-xs text-slate-500">NIM dan informasi mahasiswa</p>
                            </div>
                        </div>

                        <flux:input name="nim" label="NIM" :value="old('nim', $user->mahasiswaProfile->nim ?? '')" />
                        <flux:input name="nama_lengkap" label="Nama Lengkap" :value="old('nama_lengkap', $user->mahasiswaProfile->nama_lengkap ?? '')" />
                        <flux:select name="program_studi_id" label="Program Studi">
                            <option value="">Pilih Program Studi</option>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ old('program_studi_id', $user->mahasiswaProfile->program_studi_id ?? '') == $prodi->id ? 'selected' : '' }}>{{ $prodi->nama }} ({{ $prodi->kode }})</option>
                            @endforeach
                        </flux:select>
                        <flux:input name="angkatan" label="Angkatan" type="number" min="2000" max="2100" :value="old('angkatan', $user->mahasiswaProfile->angkatan ?? '')" />
                    </div>
                </div>
            </div>

            @if($errors->any())
                <div class="alert-error mt-6">
                    <ul class="list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-800">
                <flux:button type="submit" class="btn-primary">{{ isset($user) ? 'Update' : 'Simpan' }}</flux:button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role-select');
            const dosenSection = document.getElementById('dosen-section');
            const mahasiswaSection = document.getElementById('mahasiswa-section');
            function toggleSections() {
                const role = roleSelect.value;
                dosenSection.classList.toggle('hidden', role !== 'dosen');
                mahasiswaSection.classList.toggle('hidden', role !== 'mahasiswa');
            }
            roleSelect.addEventListener('change', toggleSections);
            @if(isset($user) && old('role', $user->role) === 'dosen')
                dosenSection.classList.remove('hidden');
            @elseif(isset($user) && old('role', $user->role) === 'mahasiswa')
                mahasiswaSection.classList.remove('hidden');
            @endif
        });
    </script>
</x-layouts::app>
