<x-layouts::app :title="__('Tambah Pertemuan')">
    <div class="p-6 lg:p-8 max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Tambah Pertemuan</h1>
                <p class="mt-1 text-sm text-zinc-500">Buat sesi pertemuan baru untuk kelas</p>
            </div>
            <a href="{{ route('dosen.jadwal.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form method="POST" action="{{ route('dosen.jadwal.store') }}" class="space-y-5">
                @csrf
                <flux:select name="kelas_kuliah_id" label="Kelas" required>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_kuliah_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} - {{ $k->mataKuliah->nama_mk ?? '' }}
                        </option>
                    @endforeach
                </flux:select>
                <flux:input name="pertemuan_ke" label="Pertemuan Ke-" type="number" :value="old('pertemuan_ke', 1)" required min="1" max="16" />
                <flux:input name="tgl_pertemuan" label="Tanggal Pertemuan" type="date" :value="old('tgl_pertemuan')" required />
                <div class="grid gap-5 sm:grid-cols-2">
                    <flux:input name="jam_mulai" label="Jam Mulai" type="time" :value="old('jam_mulai', '08:00')" required />
                    <flux:input name="jam_selesai" label="Jam Selesai" type="time" :value="old('jam_selesai', '10:30')" required />
                </div>
                <flux:select name="status_sesi" label="Status Sesi" required>
                    <option value="dibuka">Buka Sesi (aktif)</option>
                    <option value="ditutup">Tutup Sesi (non-aktif)</option>
                </flux:select>

                @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-disc pl-4 space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-center gap-3 pt-2">
                    <flux:button type="submit" icon="check" class="!bg-emerald-600 !text-white hover:!bg-emerald-700">Simpan</flux:button>
                    <a href="{{ route('dosen.jadwal.index') }}" wire:navigate>
                        <flux:button variant="subtle" type="button">Batal</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
