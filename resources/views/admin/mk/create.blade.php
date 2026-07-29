<x-layouts::app :title="__('Tambah / Edit Mata Kuliah')">
    <div class="p-6 lg:p-8 max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ isset($mk) ? 'Edit Mata Kuliah' : 'Tambah Mata Kuliah' }}</h1>
            </div>
            <a href="{{ route('admin.mk.index') }}" wire:navigate>
                <flux:button variant="subtle" icon="arrow-left">Kembali</flux:button>
            </a>
        </div>

        <div class="rounded-2xl border border-zinc-200/60 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
            <form method="POST" action="{{ isset($mk) ? route('admin.mk.update', $mk) : route('admin.mk.store') }}" class="space-y-5">
                @csrf
                @isset($mk) @method('PUT') @endisset

                @php $mkData = $mk ?? null; @endphp
                <flux:input name="kode_mk" label="Kode Mata Kuliah" :value="old('kode_mk', $mkData->kode_mk ?? '')" required placeholder="TI201" />
                <flux:input name="nama_mk" label="Nama Mata Kuliah" :value="old('nama_mk', $mkData->nama_mk ?? '')" required />
                <div class="grid gap-5 sm:grid-cols-2">
                    <flux:input name="sks" label="SKS" type="number" :value="old('sks', $mkData->sks ?? 3)" required min="1" max="6" />
                    <flux:input name="semester" label="Semester" type="number" :value="old('semester', $mkData->semester ?? 1)" required min="1" max="8" />
                </div>
                <flux:select name="program_studi_id" label="Program Studi" required>
                    @foreach($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ (old('program_studi_id', $mkData->program_studi_id ?? '') == $prodi->id) ? 'selected' : '' }}>
                            {{ $prodi->kode }} - {{ $prodi->nama }}
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
                    <flux:button type="submit" icon="check" class="!bg-emerald-600 !text-white hover:!bg-emerald-700">{{ isset($mk) ? 'Update' : 'Simpan' }}</flux:button>
                    <a href="{{ route('admin.mk.index') }}" wire:navigate>
                        <flux:button variant="subtle" type="button">Batal</flux:button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app>
