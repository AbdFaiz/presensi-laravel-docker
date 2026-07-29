<x-layouts::app :title="__('Tambah / Edit User')">
    <div class="p-6 lg:p-8 max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ isset($user) ? 'Edit User' : 'Tambah User' }}</h1>
                <p class="mt-1 text-sm text-zinc-500">{{ isset($user) ? 'Ubah data pengguna' : 'Buat akun baru untuk pengguna' }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" class="space-y-5">
                @csrf
                @isset($user) @method('PUT') @endisset
                <div class="grid gap-5 sm:grid-cols-2">
                    <flux:input name="name" label="Nama" :value="old('name', $user->name ?? '')" required />
                    <flux:input name="username" label="Username (NIM/NIP)" :value="old('username', $user->username ?? '')" required />
                </div>
                <flux:input name="email" label="Email" type="email" :value="old('email', $user->email ?? '')" required />
                <div class="grid gap-5 sm:grid-cols-2">
                    <flux:input name="password" label="{{ isset($user) ? 'Password Baru (kosongkan jika tidak diubah)' : 'Password' }}" type="password" {{ isset($user) ? '' : 'required' }} />
                    <flux:input name="password_confirmation" label="Konfirmasi Password" type="password" {{ isset($user) ? '' : 'required' }} />
                </div>
                <flux:select name="role" label="Role" required>
                    <option value="admin" {{ (old('role', $user->role ?? '') == 'admin') ? 'selected' : '' }}>Admin</option>
                    <option value="dosen" {{ (old('role', $user->role ?? '') == 'dosen') ? 'selected' : '' }}>Dosen</option>
                    <option value="mahasiswa" {{ (old('role', $user->role ?? '') == 'mahasiswa') ? 'selected' : '' }}>Mahasiswa</option>
                </flux:select>

                @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-900/20 dark:text-red-400">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <flux:button type="submit" icon="check" class="!bg-emerald-600 !text-white hover:!bg-emerald-700">{{ isset($user) ? 'Update' : 'Simpan' }}</flux:button>
                    <a href="{{ route('admin.users.index') }}" wire:navigate>
                        <flux:button variant="subtle" type="button">Batal</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
