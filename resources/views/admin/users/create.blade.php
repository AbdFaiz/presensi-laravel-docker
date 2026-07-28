<x-layouts::app :title="__('Tambah User')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Tambah User</flux:heading>
            <a href="{{ route('admin.users.index') }}" wire:navigate>
                <flux:button variant="subtle">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                @csrf
                <flux:input name="name" label="Nama" :value="old('name')" required />
                <flux:input name="username" label="Username (NIM/NIP)" :value="old('username')" required />
                <flux:input name="email" label="Email" type="email" :value="old('email')" required />
                <flux:input name="password" label="Password" type="password" required />
                <flux:input name="password_confirmation" label="Konfirmasi Password" type="password" required />
                <flux:select name="role" label="Role" required>
                    <option value="admin">Admin</option>
                    <option value="dosen">Dosen</option>
                    <option value="mahasiswa" selected>Mahasiswa</option>
                </flux:select>

                @if($errors->any())
                    <div class="text-sm text-red-500">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <flux:button type="submit" icon="check">Simpan</flux:button>
            </form>
        </div>
    </div>
</x-layouts::app>
