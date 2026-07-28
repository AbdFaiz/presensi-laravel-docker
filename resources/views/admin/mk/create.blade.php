<x-layouts::app :title="__('Tambah Mata Kuliah')">
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <div class="flex items-center justify-between">
            <flux:heading size="xl">Tambah Mata Kuliah</flux:heading>
            <a href="{{ route('admin.mk.index') }}" wire:navigate>
                <flux:button variant="subtle">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-xl border border-neutral-200 bg-white p-6 dark:border-neutral-700 dark:bg-zinc-800">
            <form method="POST" action="{{ route('admin.mk.store') }}" class="space-y-4">
                @csrf
                <flux:input name="kode_mk" label="Kode MK" :value="old('kode_mk')" required placeholder="TI201" />
                <flux:input name="nama_mk" label="Nama Mata Kuliah" :value="old('nama_mk')" required />
                <div class="grid grid-cols-2 gap-4">
                    <flux:input name="sks" label="SKS" type="number" :value="old('sks')" required min="1" max="6" />
                    <flux:input name="semester" label="Semester" type="number" :value="old('semester')" required min="1" max="8" />
                </div>
                <flux:select name="program_studi_id" label="Program Studi" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ old('program_studi_id') == $prodi->id ? 'selected' : '' }}>
                            {{ $prodi->kode }} - {{ $prodi->nama }}
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
