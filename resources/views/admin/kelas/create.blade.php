<x-layouts::app :title="__('Tambah / Edit Kelas')">
    <div class="p-6 lg:p-8 max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ isset($kelas) ? 'Edit Kelas' : 'Tambah Kelas' }}</h1>
            </div>
            <a href="{{ route('admin.kelas.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
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
                        <option value="{{ $mk->id }}" {{ (old('mata_kuliah_id', $k->mata_kuliah_id ?? '') == $mk->id) ? 'selected' : '' }}>
                            {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                        </option>
                    @endforeach
                </flux:select>
                <flux:select name="dosen_id" label="Dosen Pengampu" required>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ (old('dosen_id', $k->dosen_id ?? '') == $dosen->id) ? 'selected' : '' }}>
                            {{ $dosen->nama_lengkap }} ({{ $dosen->nip }})
                        </option>
                    @endforeach
                </flux:select>

                @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <flux:button type="submit" icon="check" class="!bg-emerald-600 !text-white hover:!bg-emerald-700">{{ isset($kelas) ? 'Update' : 'Simpan' }}</flux:button>
                    <a href="{{ route('admin.kelas.index') }}" wire:navigate>
                        <flux:button variant="subtle" type="button">Batal</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
