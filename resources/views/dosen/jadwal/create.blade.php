<x-layouts::app :title="__('Tambah Pertemuan')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Tambah Pertemuan</flux:heading>
            <a href="{{ route('dosen.jadwal.index') }}" wire:navigate>
                <flux:button variant="subtle">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
            <form method="POST" action="{{ route('dosen.jadwal.store') }}" class="space-y-4">
                @csrf
                <flux:select name="kelas_kuliah_id" label="Kelas" required>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_kuliah_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }} - {{ $k->mataKuliah->nama_mk ?? '' }}
                        </option>
                    @endforeach
                </flux:select>
                <flux:input name="pertemuan_ke" label="Pertemuan Ke-" type="number" :value="old('pertemuan_ke', 1)" required min="1" max="16" />
                <flux:input name="tgl_pertemuan" label="Tanggal Pertemuan" type="date" :value="old('tgl_pertemuan')" required />
                <div class="grid grid-cols-2 gap-4">
                    <flux:input name="jam_mulai" label="Jam Mulai" type="time" :value="old('jam_mulai', '08:00')" required />
                    <flux:input name="jam_selesai" label="Jam Selesai" type="time" :value="old('jam_selesai', '10:30')" required />
                </div>
                <flux:select name="status_sesi" label="Status Sesi" required>
                    <option value="dibuka">Dibuka</option>
                    <option value="ditutup">Ditutup</option>
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
