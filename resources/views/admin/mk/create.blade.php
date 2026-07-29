<x-layouts::app :title="__('Tambah / Edit Mata Kuliah')">
    <div class="p-4 sm:p-6 lg:p-8 max-w-3xl mx-auto space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ isset($mk) ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' }}</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ isset($mk) ? 'Ubah data mata kuliah' : 'Buat mata kuliah baru' }}</p>
            </div>
            <a href="{{ route('admin.mk.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="card-unas">
            <div class="px-8 py-6">
                <form method="POST" action="{{ isset($mk) ? route('admin.mk.update', $mk) : route('admin.mk.store') }}" class="space-y-5">
                    @csrf
                    @isset($mk) @method('PUT') @endisset

                    @php $m = $mk ?? null; @endphp
                    <div class="grid gap-5 sm:grid-cols-2">
                        <flux:input name="kode_mk" label="Kode MK" :value="old('kode_mk', $m->kode_mk ?? '')" required placeholder="TI101" />
                        <flux:input name="nama_mk" label="Nama Mata Kuliah" :value="old('nama_mk', $m->nama_mk ?? '')" required placeholder="Algoritma Pemrograman" />
                    </div>
                    <div class="grid gap-5 sm:grid-cols-3">
                        <flux:input name="sks" label="SKS" type="number" min="1" max="6" :value="old('sks', $m->sks ?? '')" required />
                        <flux:input name="semester" label="Semester" type="number" min="1" max="14" :value="old('semester', $m->semester ?? '')" required />
                        <flux:select name="program_studi_id" label="Program Studi" required>
                            @foreach($prodis as $prodi)
                                <option value="{{ $prodi->id }}" {{ (old('program_studi_id', $m->program_studi_id ?? '') == $prodi->id) ? 'selected' : '' }}>{{ $prodi->nama }} ({{ $prodi->kode }})</option>
                            @endforeach
                        </flux:select>
                    </div>

                    @if($errors->any())
                        <div class="alert-error">
                            <ul class="list-disc pl-4 space-y-1">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="pt-2">
                        <flux:button type="submit" class="btn-primary">{{ isset($mk) ? 'Update' : 'Simpan' }}</flux:button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts::app>
