<x-layouts::app :title="__('Tambah Pertemuan')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-3xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Tambah Pertemuan</h1>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Buat sesi pertemuan perkuliahan baru</p>
            </div>
            <a href="{{ route('dosen.jadwal.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="card-unas">
            <div class="px-8 py-6">
                <form method="POST" action="{{ route('dosen.jadwal.store') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <flux:select name="kelas_kuliah_id" label="Kelas" required>
                            @foreach($kelas as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }} - {{ $kelas->mataKuliah->nama_mk }}</option>
                            @endforeach
                        </flux:select>
                        <flux:input type="number" name="pertemuan_ke" label="Pertemuan Ke-" min="1" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <flux:input type="date" name="tgl_pertemuan" label="Tanggal" required />
                        <flux:input type="time" name="jam_mulai" label="Jam Mulai" required />
                        <flux:input type="time" name="jam_selesai" label="Jam Selesai" required />
                    </div>

                    @if($errors->any())
                        <div class="alert-error">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-2">
                        <flux:button type="submit" class="btn-primary">Simpan</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
