@extends('layouts.app-admin')

@section('title', 'Edit Prestasi')

@section('content')
<div class="max-w-full min-h-[88vh] flex justify-center items-center">
    <div class="bg-white w-full h-full p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Data Prestasi</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('prestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kepesertaan -->
                <div>
                    <label for="kepesertaan" class="block text-gray-700">Kepesertaan</label>
                    <select name="kepesertaan_lomba" class="bg-gray-200 px-4 py-2 rounded-lg w-full" required>
                        <option value="">Pilih Kepesertaan</option>
                        @foreach($kepesertaan as $data)
                            <option value="{{ $data->id }}" {{ $data->id == $prestasi->kepesertaan_lomba ? 'selected' : '' }}>
                                {{ $data->jenis_kepesertaan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="kategori" class="block text-gray-700">Kategori</label>
                    <select name="kategori_lomba" id="kategori-lomba" class="bg-gray-200 px-4 py-2 rounded-lg w-full" required>
                        <option value="">PILIH KATEGORI</option>
                        @foreach($kategori as $data)
            
                            <option value="{{ $data->id }}" {{ $data->id == $prestasi->kategori_lomba ? 'selected' : '' }}>{{ $data->kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6">
                <label for="jenis-prestasi" class="block text-gray-700">Jenis Prestasi</label>
                <select name="jenis_prestasi" id="jenis-prestasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                    <option value="">JENIS PRESTASI</option>
                    @foreach($jenisPrestasi as $data)
                        <option value="{{ $data->id }}" value="{{ $data->id }}" {{ $data->id == $prestasi->jenis_prestasi ? 'selected' : '' }}>{{ $data->prestasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <label for="nama-kegiatan" class="block text-gray-700">Nama Kegiatan</label>
                <input required type="text" name="nama_kegiatan" id="nama-kegiatan" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Nama Kegiatan" value="{{ $prestasi->nama_kegiatan }}">
            </div>
            <div class="mt-6">
                <label for="judul" class="block text-gray-700">Judul Program/Karya</label>
                <input required type="text" name="judul_karya" id="judul" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Judul Program / Karya" value="{{ $prestasi->judul_karya }}">
            </div>
            <div class="mt-6">
                <label for="lokasi" class="block text-gray-700">Lokasi Kegiatan</label>
                <input required type="text" name="lokasi_kegiatan" id="lokasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Lokasi Kegiatan" value="{{ $prestasi->lokasi_kegiatan }}">
            </div>
            <div class="flex justify-between w-full items-center mt-6">
                <div class="w-4/12">
                    <label for="mulai" class="block text-gray-700">Tanggal Mulai</label>
                    <input required type="date" name="tanggal_mulai" id="mulai" class="bg-gray-200 px-4 py-2 rounded-lg w-full" value="{{ $prestasi->tanggal_mulai }}">

                </div>
        
                <p class="font-semibold">s/d</p>

                <div class="w-4/12">
                    <label for="akhir" class="block text-gray-700">Tanggal Akhir</label>
                    <input required type="date" name="tanggal_selesai" id="akhir" class="bg-gray-200 px-4 py-2 rounded-lg w-full" value="{{ $prestasi->tanggal_selesai }}">
                </div>
            </div>
            <div class="mt-6">
                <label for="nama-penyelenggara" class="block text-gray-700">Nama Penyelenggara</label>
                <input required type="text" name="nama_penyelenggara" id="nama-penyelenggara" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Nama Penyelenggara" value="{{ $prestasi->nama_penyelenggara }}">
            </div>
            <div class="mt-6">
                <label for="publikasi" class="block text-gray-700">Publikasi / Penyelenggara</label>
                <input required type="text" name="publikasi" id="publikasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Publikasi" value="{{ $prestasi->penyelenggara }}">
            </div>
            <div class="mt-6">
                <label for="jumlah-negara" class="block text-gray-700">Jumlah Partisipasi Negara</label>
                <input required type="number" min="0" name="jumlah_negara" id="jumlah-negara" class="bg-gray-200 px-4 py-2 rounded-lg w-full" 
                       placeholder="Masukkan Jumlah Partipasi Negara" 
                       value="{{ $prestasi->partisipan->jumlah_partisipan_negara }}" 
                       {{ $prestasi->kategori->kategori == 'INTERNASIONAL' || $prestasi->kategori->kategori == 'INTERNATIONAL' ? '' : 'readonly' }}>
            </div>
            <div class="mt-6">
                <label for="jumlah-peserta" class="block text-gray-700">Jumlah Partisipasi Peserta</label>
                <input required type="number" min="0" name="jumlah_peserta" id="jumlah-peserta" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Jumlah Partipasi Peserta" value="{{ $prestasi->partisipan->jumlah_partisipan_peserta }}">
            </div>
            <div class="mt-6">
                <label for="jumlah-team" class="block text-gray-700">Jumlah Partisipasi Team</label>
                <input required type="number" min="0" name="jumlah_team" id="jumlah-team" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Jumlah Partipasi Team" value="{{ $prestasi->partisipan->jumlah_partisipan_team }}">
            </div>
            <div class="mt-6">
                <label for="jumlah-perguruan-tinggi" class="block text-gray-700">Jumlah Partisipasi Perguruan Tinggi</label>
                <input required type="number" min="0" name="jumlah_perguruan_tinggi" id="jumlah-perguruan-tinggi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Jumlah Partipasi Perguruan Tinggi" value="{{ $prestasi->partisipan->jumlah_partisipan_kampus }}">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="capaian" class="block text-gray-700">Capaian Juara</label>
                    <select name="kategori_juara" id="capaian" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                        <option value="">CAPAIAN JUARA</option>
                        @foreach($capaianJuara as $data)
                            <option value="{{ $data->id }}" {{ $data->id == $prestasi->kategori_juara ? 'selected' : '' }}>
                                {{ $data->jenis_juara }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <div>
                    <label for="posisi" class="block text-gray-700">Posisi</label>
                    <select name="posisi_peserta" id="posisi" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                        <option value="">POSISI</option>
                        @foreach($posisi as $data)
                            <option value="{{ $data->id }}" {{ $data->id == $prestasi->posisi_peserta ? 'selected' : '' }}>
                                {{ $data->posisi }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 relative">
                <label for="nama-mahasiswa" class="block text-gray-700">Nama Mahasiswa</label>
                <input required type="text" id="nama-mahasiswa" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Cari Nama Mahasiswa..." value="{{ $prestasi->mahasiswa->nama }}">
                <input type="hidden" name="data_mahasiswa" id="id-mahasiswa" value="{{ $prestasi->mahasiswa->id }}">
                <div id="mahasiswa-search-results" class="absolute w-full bg-white shadow-md rounded-lg mt-1 z-50 hidden"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="nim" class="block text-gray-700">NIM</label>
                    <input required type="number" id="nim" name="nim" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="NIM Mahasiswa" readonly value="{{ $prestasi->mahasiswa->NIM}}">
                </div>
                
                <div>
                    <label for="program_studi" class="block text-gray-700">Program Studi</label>
                    <input required type="text" id="program_studi" name="program_studi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Program Studi Mahasiswa" readonly value="{{ $prestasi->mahasiswa->prodi->study_program}}">
                </div>
            </div>
            
            <div class="mt-6 relative">
                <label for="nama-dospem" class="block text-gray-700">Nama Dosen Pendamping</label>
                <input required type="text" id="nama-dospem" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Cari Nama Dosen..." value="{{ $prestasi->dosenPembimbing->nama }}">
                <input type="hidden" name="data_dospen" value="{{ $prestasi->dosenPembimbing->id }}"> 
                <div id="dospem-search-results" class="absolute w-full bg-white shadow-md rounded-lg mt-1 z-50 hidden"></div>
            </div>
            <div class="mt-6">
                <label for="nidn" class="block text-gray-700">NIDN</label>
                <input required type="number" id="nidn" name="nidn" class="bg-gray-200 px-4 py-2 rounded-lg w-6/12" placeholder="NIDN DOSEN PENDAMPING" readonly value="{{ $prestasi->dosenPembimbing->NIDN }}">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="surat_izin" class="block text-gray-700">Unggah Surat Tugas / Izin (PDF)</label>
                    <input type="file" name="surat_izin" id="surat_izin" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                    @if($prestasi->fileUpload && $prestasi->fileUpload->url_surat_tugas)
                        <p class="mt-2">
                            Current File: <a href="{{ Storage::url($prestasi->fileUpload->url_surat_tugas) }}" target="_blank" class="text-blue-600 hover:underline">View Surat Tugas</a>
                        </p>
                    @endif
                </div>
            
                <div>
                    <label for="sertifikat" class="block text-gray-700">Unggah Sertifikat (PDF)</label>
                    <input type="file" name="sertifikat" id="sertifikat" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                    @if($prestasi->fileUpload && $prestasi->fileUpload->url_certificate)
                        <p class="mt-2">
                            Current File: <a href="{{ Storage::url($prestasi->fileUpload->url_certificate) }}" target="_blank" class="text-blue-600 hover:underline">View Sertifikat</a>
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="upp" class="block text-gray-700">Unggah Foto UPP (PNG/JPG/JPEG)</label>
                    <input type="file" name="upp" id="upp" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                    @if($prestasi->fileUpload && $prestasi->fileUpload->url_upp)
                        <p class="mt-2">
                            Current File: <img src="{{ Storage::url($prestasi->fileUpload->url_upp) }}" alt="UPP Image" class="w-32 h-auto">
                        </p>
                    @endif
                </div>
            
                <div>
                    <label for="rekomendasi" class="block text-gray-700">Unggah Surat Rekomendasi (PDF)</label>
                    <input type="file" name="rekomendasi" id="rekomendasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                    @if($prestasi->fileUpload && $prestasi->fileUpload->url_rekomendasi)
                        <p class="mt-2">
                            Current File: <a href="{{ Storage::url($prestasi->fileUpload->url_rekomendasi) }}" target="_blank" class="text-blue-600 hover:underline">View Surat Rekomendasi</a>
                        </p>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="nomor_surat_tugas" class="block text-gray-700">Nomor Surat Tugas</label>
                    <input required type="number" name="no_surat_tugas" id="nomor_surat_tugas" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Nomor Surat Tugas" value="{{ $prestasi->nomor_surat_tugas }}">
                </div>
        
                <div>
                    <label for="tanggal_surat_tugas" class="block text-gray-700">Tanggal Surat Tugas</label>
                    <input required type="date" name="tgl_surat_tugas" id="tanggal_surat_tugas" class="bg-gray-200 px-4 py-2 rounded-lg w-full" value="{{ $prestasi->tanggal_surat_tugas }}">
                </div>
            </div>
            <div class="mt-6">
                <label for="keterangan" class="block text-gray-700">KETERANGAN ( OPTIONAL )</label>
                <textarea name="keterangan" id="keterangan" class="bg-gray-200 px-4 py-2 rounded-lg w-full" rows="4" cols="50">{{ $prestasi->keterangan ? $prestasi->keterangan : ''}}</textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg">Update Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const kategoriLomba = document.getElementById('kategori-lomba');
        const jumlahNegara = document.getElementById('jumlah-negara');
        
        function checkKategori() {
            const selectedOption = kategoriLomba.selectedOptions[0].text; 
            console.log({ selectedOption });

            if (selectedOption === 'INTERNASIONAL' || selectedOption === 'INTERNATIONAL') {
                jumlahNegara.value = '';
                jumlahNegara.readOnly = false;
            } else {
                jumlahNegara.value = 1;
                jumlahNegara.readOnly = true;
            }
        }

        checkKategori();

        kategoriLomba.addEventListener('change', checkKategori);
    });
    document.getElementById('nama-mahasiswa').addEventListener('input', function () {
        const query = this.value;

        if (query.length >= 3) {
            fetch(`{{ route('search-mahasiswa') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    const resultsDiv = document.getElementById('mahasiswa-search-results');
                    resultsDiv.innerHTML = ''; // Clear previous results
                    if (data.length > 0) {
                        resultsDiv.classList.remove('hidden');
                        data.forEach(student => {
                            resultsDiv.innerHTML += `
                                <div class="p-2 cursor-pointer hover:bg-gray-200" data-nama="${student.nama}" data-id="${student.id}" data-nim="${student.NIM}" data-prodi="${student.prodi}">
                                    ${student.nama} - ${student.NIM}
                                </div>
                            `;
                        });
                    } else {
                        resultsDiv.innerHTML = '<div class="p-2 text-gray-700">No results found</div>';
                    }

                    // Add click event for each result
                    document.querySelectorAll('#mahasiswa-search-results div').forEach(div => {
                        div.addEventListener('click', function () {
                            document.getElementById('nama-mahasiswa').value = this.getAttribute('data-nama');
                            document.getElementById('nim').value = this.getAttribute('data-nim');
                            document.getElementById('program_studi').value = this.getAttribute('data-prodi');
                            document.getElementById('id-mahasiswa').value = this.getAttribute('data-id')
                            resultsDiv.classList.add('hidden'); // Hide the results div
                        });
                    });
                });
        } else {
            document.getElementById('mahasiswa-search-results').classList.add('hidden');
        }
    });

    document.getElementById('nama-dospem').addEventListener('input', function () {
        const query = this.value;

        if (query.length >= 3) {
            fetch(`{{ route('search-dospem') }}?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    const resultsDiv = document.getElementById('dospem-search-results');
                    resultsDiv.innerHTML = '';
                    if (data.length > 0) {
                        resultsDiv.classList.remove('hidden');
                        data.forEach(dosen => {
                            resultsDiv.innerHTML += `
                                <div class="p-2 cursor-pointer hover:bg-gray-200" data-id="${dosen.id}" data-nama="${dosen.nama}" data-nidn="${dosen.NIDN}">${dosen.nama} - ${dosen.NIDN}</div>
                            `;
                        });
                    } else {
                        resultsDiv.innerHTML = '<div class="p-2 text-gray-700">No results found</div>';
                    }

                    // Add click event for each result
                    document.querySelectorAll('#dospem-search-results div').forEach(div => {
                        div.addEventListener('click', function () {
                            document.getElementById('nama-dospem').value = this.getAttribute('data-nama');
                            document.getElementById('nidn').value = this.getAttribute('data-nidn');
                            document.getElementById('id-dosen').value = this.getAttribute('data-id')
                            resultsDiv.classList.add('hidden');
                        });
                    });
                });
        } else {
            document.getElementById('dospem-search-results').classList.add('hidden');
        }
    });
</script>
@endsection
