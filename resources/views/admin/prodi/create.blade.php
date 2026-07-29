<x-layouts::app :title="__('Tambah / Edit Program Studi')">
    <div class="p-6 lg:p-8 max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ isset($prodi) ? 'Edit Program Studi' : 'Tambah Program Studi' }}</h1>
            </div>
            <a href="{{ route('admin.prodi.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form method="POST" action="{{ isset($prodi) ? route('admin.prodi.update', $prodi) : route('admin.prodi.store') }}" class="space-y-5">
                @csrf
                @isset($prodi) @method('PUT') @endisset
                <div class="grid gap-5 sm:grid-cols-2">
                    <flux:input name="kode" label="Kode" :value="old('kode', $prodi->kode ?? '')" required placeholder="TI" />
                    <flux:input name="nama" label="Nama Program Studi" :value="old('nama', $prodi->nama ?? '')" required />
                </div>
                <flux:textarea name="deskripsi" label="Deskripsi">{{ old('deskripsi', $prodi->deskripsi ?? '') }}</flux:textarea>

                @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <flux:button type="submit" icon="check" class="!bg-emerald-600 !text-white hover:!bg-emerald-700">{{ isset($prodi) ? 'Update' : 'Simpan' }}</flux:button>
                    <a href="{{ route('admin.prodi.index') }}" wire:navigate>
                        <flux:button variant="subtle" type="button">Batal</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
