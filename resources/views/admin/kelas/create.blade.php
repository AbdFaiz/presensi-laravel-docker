<x-layouts::app :title="__('Tambah / Edit Kelas')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-3xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas' }}</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ isset($kelas) ? 'Ubah data kelas' : 'Buat kelas baru' }}</p>
            </div>
            <a href="{{ route('admin.kelas.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="card-unas">
            <div class="px-8 py-6">
                <form method="POST" action="{{ isset($kelas) ? route('admin.kelas.update', $kelas) : route('admin.kelas.store') }}" class="space-y-5">
                    @csrf
                    @isset($kelas) @method('PUT') @endisset

                    @php $k = $kelas ?? null; @endphp
                    <div class="grid gap-5 sm:grid-cols-2">
                        <flux:input name="nama_kelas" label="Nama Kelas" :value="old('nama_kelas', $k->nama_kelas ?? '')" required placeholder="TI-4A" />
                        <flux:input name="tahun_akademik" label="Tahun Akademik" :value="old('tahun_akademik', $k->tahun_akademik ?? '')" required placeholder="2025/2026" />
                    </div>
                    <flux:select name="mata_kuliah_id" label="Mata Kuliah" required>
                        @foreach($matkuls as $mk)
                            <option value="{{ $mk->id }}" {{ (old('mata_kuliah_id', $k->mata_kuliah_id ?? '') == $mk->id) ? 'selected' : '' }}>{{ $mk->kode_mk }} - {{ $mk->nama_mk }}</option>
                        @endforeach
                    </flux:select>
                    <flux:select name="dosen_id" label="Dosen Pengampu" required>
                        @foreach($dosens as $dosen)
                            <option value="{{ $dosen->id }}" {{ (old('dosen_id', $k->dosen_id ?? '') == $dosen->id) ? 'selected' : '' }}>{{ $dosen->nama_lengkap }} ({{ $dosen->nip }})</option>
                        @endforeach
                    </flux:select>

                    @if($errors->any())
                        <div class="alert-error">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-2">
                        <flux:button type="submit" class="btn-primary">{{ isset($kelas) ? 'Update' : 'Simpan' }}</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
