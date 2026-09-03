@extends('layouts.app-admin')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="max-w-full min-h-[88vh] flex justify-center items-center">
    <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Mahasiswa</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('mahasiswa.update', $mahasiswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama dan NIM -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama" class="block text-gray-700">Nama</label>
                    <input type="text" id="nama" name="nama" class="bg-gray-200 px-4 py-2 rounded-lg w-full" value="{{ $mahasiswa->nama }}" required>
                    @error('nama')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="nim" class="block text-gray-700">NIM</label>
                    <input type="text" id="nim" name="NIM" class="bg-gray-200 px-4 py-2 rounded-lg w-full" value="{{ $mahasiswa->NIM }}" required>
                    @error('NIM')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Fakultas dan Program Studi -->
            <div class="mt-6">
                <label for="fakultas" class="block text-gray-700">Fakultas</label>
                <select id="fakultas" name="faculty_id" class="bg-gray-200 px-4 py-2 rounded-lg w-full" required>
                    <option value="">Pilih Fakultas</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}" {{ $mahasiswa->faculty == $faculty->id ? 'selected' : '' }}>{{ $faculty->name_faculty }}</option>
                    @endforeach
                </select>
                @error('faculty_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-6">
                <label for="prodi" class="block text-gray-700">Program Studi</label>
                <select id="prodi" name="prodi_id" class="bg-gray-200 px-4 py-2 rounded-lg w-full" required>
                    <option value="">Pilih Program Studi</option>
                    @foreach ($prodis as $prodi)
                        <option value="{{ $prodi->id }}" {{ $mahasiswa->prodi_id == $prodi->id ? 'selected' : '' }}>{{ $prodi->study_program }}</option>
                    @endforeach
                </select>
                @error('prodi_id')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('fakultas').addEventListener('change', function () {
        var fakultasId = this.value;
        var prodiSelect = document.getElementById('prodi');

        if (!fakultasId) {
            prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            return;
        }

        fetch(`{{ url('/get-prodi-by-faculty') }}/${fakultasId}`)
            .then(response => response.json())
            .then(data => {
                prodiSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                data.forEach(prodi => {
                    var option = document.createElement('option');
                    option.value = prodi.id;
                    option.textContent = prodi.study_program;
                    prodiSelect.appendChild(option);
                });
            });
    });
</script>

@endsection
