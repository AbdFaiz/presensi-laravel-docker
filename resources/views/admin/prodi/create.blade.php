<x-layouts::app :title="__('Tambah Program Studi')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Tambah Program Studi</flux:heading>
            <a href="{{ route('admin.prodi.index') }}" wire:navigate>
                <flux:button variant="subtle">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
            <form method="POST" action="{{ route('admin.prodi.store') }}" class="space-y-4">
                @csrf
                <flux:input name="kode" label="Kode" :value="old('kode')" required placeholder="TI" />
                <flux:input name="nama" label="Nama Program Studi" :value="old('nama')" required />
                <flux:textarea name="deskripsi" label="Deskripsi">{{ old('deskripsi') }}</flux:textarea>

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
