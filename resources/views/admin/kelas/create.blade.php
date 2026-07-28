<x-layouts::app :title="__('Tambah Kelas')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Tambah Kelas</flux:heading>
            <a href="{{ route('admin.kelas.index') }}" wire:navigate>
                <flux:button variant="subtle">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
            <form method="POST" action="{{ route('admin.kelas.store') }}" class="space-y-4">
                @csrf
                <flux:input name="nama_kelas" label="Nama Kelas" :value="old('nama_kelas')" required placeholder="TI-4A" />
                <flux:input name="tahun_akademik" label="Tahun Akademik" :value="old('tahun_akademik')" required placeholder="2025/2026" />
                <flux:select name="mata_kuliah_id" label="Mata Kuliah" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    @foreach($matkuls as $mk)
                        <option value="{{ $mk->id }}" {{ old('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                            {{ $mk->kode_mk }} - {{ $mk->nama_mk }}
                        </option>
                    @endforeach
                </flux:select>
                <flux:select name="dosen_id" label="Dosen Pengampu" required>
                    <option value="">-- Pilih Dosen --</option>
                    @foreach($dosens as $dosen)
                        <option value="{{ $dosen->id }}" {{ old('dosen_id') == $dosen->id ? 'selected' : '' }}>
                            {{ $dosen->nama_lengkap }} ({{ $dosen->nip }})
                        </option>
                    @endforeach
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
