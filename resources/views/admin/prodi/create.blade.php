<x-layouts::app :title="__('Tambah / Edit Program Studi')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-3xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ isset($prodi) ? 'Edit Program Studi' : 'Tambah Program Studi' }}</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ isset($prodi) ? 'Ubah data program studi' : 'Buat program studi baru' }}</p>
            </div>
            <a href="{{ route('admin.prodi.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="card-unas">
            <div class="px-8 py-6">
                <form method="POST" action="{{ isset($prodi) ? route('admin.prodi.update', $prodi) : route('admin.prodi.store') }}" class="space-y-5">
                    @csrf
                    @isset($prodi) @method('PUT') @endisset

                    @php $p = $prodi ?? null; @endphp
                    <div class="grid gap-5 sm:grid-cols-2">
                        <flux:input name="kode" label="Kode Prodi" :value="old('kode', $p->kode ?? '')" required placeholder="TI" />
                        <flux:input name="nama" label="Nama Program Studi" :value="old('nama', $p->nama ?? '')" required placeholder="Teknik Informatika" />
                    </div>
                    <flux:textarea name="deskripsi" label="Deskripsi" :value="old('deskripsi', $p->deskripsi ?? '')" rows="3" placeholder="Deskripsi program studi..." />

                    @if($errors->any())
                        <div class="alert-error">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-2">
                        <flux:button type="submit" class="btn-primary">{{ isset($prodi) ? 'Update' : 'Simpan' }}</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
