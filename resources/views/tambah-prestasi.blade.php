@extends('layouts.app-admin')

@section('title', 'Tambah Prestasi')

@section('content')
<div class="max-w-full min-h-[88vh] flex justify-center items-center">
    <div class="bg-white w-full h-full p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Data Prestasi</h1>

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

        <form action="{{ route('tambah-prestasi') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="kepesertaan" class="block text-gray-700">Kepesertaan</label>
                    <select name="kepesertaan_lomba" class="bg-gray-200 px-4 py-2 rounded-lg w-full" required>
                        <option value="">PILIH KEPESERTAAN</option>
                        @foreach($kepesertaan as $data)
                            <option value="{{ $data->id }}">{{ $data->jenis_kepesertaan }}</option>
                        @endforeach
                    </select>
                </div>
        
                <div>
                    <label for="kategori" class="block text-gray-700">Kategori</label>
                    <select name="kategori_lomba" id="kategori-lomba" class="bg-gray-200 px-4 py-2 rounded-lg w-full" required>
                        <option value="">PILIH KATEGORI</option>
                        @foreach($kategori as $data)
                            <option value="{{ $data->id }}">{{ $data->kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6">
                <label for="jenis-prestasi" class="block text-gray-700">Jenis Prestasi</label>
                <select name="jenis_prestasi" id="jenis-prestasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                    <option value="">PILIH JENIS PRESTASI</option>
                    @foreach($jenisPrestasi as $data)
                        <option value="{{ $data->id }}">{{ $data->prestasi }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-6">
                <label for="nama-kegiatan" class="block text-gray-700">Nama Kegiatan</label>
                <input required type="text" name="nama_kegiatan" id="nama-kegiatan" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Nama Kegiatan">
            </div>
            <div class="mt-6">
                <label for="judul" class="block text-gray-700">Judul Program/Karya</label>
                <input required type="text" name="judul_karya" id="judul" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Judul Program / Karya">
            </div>
            <div class="mt-6">
                <label for="lokasi" class="block text-gray-700">Lokasi Kegiatan</label>
                <input required type="text" name="lokasi_kegiatan" id="lokasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Lokasi Kegiatan">
            </div>
            <div class="mt-6">
                <label for="mulai" class="block text-gray-700">Tanggal Mulai</label>
                <input required type="date" name="tanggal_mulai" id="mulai" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
            </div>
            <div class="mt-6">
                <label for="akhir" class="block text-gray-700">Tanggal Akhir</label>
                <input required type="date" name="tanggal_selesai" id="akhir" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
            </div>
            <div class="mt-6">
                <label for="nama-penyelenggara" class="block text-gray-700">Nama Penyelenggara</label>
                <input required type="text" name="nama_penyelenggara" id="nama-penyelenggara" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Nama Penyelenggara">
            </div>
            <div class="mt-6">
                <label for="publikasi" class="block text-gray-700">Publikasi / Penyelenggara</label>
                <input required type="text" name="publikasi" id="publikasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Publikasi">
            </div>
            <div class="mt-6">
                <label for="jumlah-negara" class="block text-gray-700">Jumlah Partisipasi Negara</label>
                <input required type="number" min="0" name="jumlah_negara" id="jumlah-negara" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Jumlah Partipasi Negara">
            </div>
            <div class="mt-6">
                <label for="jumlah-peserta" class="block text-gray-700">Jumlah Partisipasi Peserta</label>
                <input required type="number" min="0" name="jumlah_peserta" id="jumlah-peserta" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Jumlah Partipasi Peserta">
            </div>
            <div class="mt-6">
                <label for="jumlah-team" class="block text-gray-700">Jumlah Partisipasi Team</label>
                <input required type="number" min="0" name="jumlah_team" id="jumlah-team" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Jumlah Partipasi Team">
            </div>
            <div class="mt-6">
                <label for="jumlah-perguruan-tinggi" class="block text-gray-700">Jumlah Partisipasi Perguruan Tinggi</label>
                <input required type="number" min="0" name="jumlah_perguruan_tinggi" id="jumlah-perguruan-tinggi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Jumlah Partipasi Perguruan Tinggi">
            </div>
            <div class="space-y-6 mt-6">
                <div>
                    <label for="capaian" class="block text-gray-700">Capaian Juara</label>
                    <select name="kategori_juara" id="capaian" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                        <option value="">PILIH CAPAIAN JUARA</option>
                        @foreach($capaianJuara as $data)
                            <option value="{{ $data->id }}">{{ $data->jenis_juara }}</option>
                        @endforeach
                    </select>
                </div>
        
                <div>
                    <label for="posisi" class="block text-gray-700">Posisi</label>
                    <select name="posisi_peserta" id="posisi" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
                        <option value="">PILIH POSISI</option>
                        @foreach($posisi as $data)
                            <option value="{{ $data->id }}">{{ $data->posisi }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-6 relative">
                <label for="nama-mahasiswa" class="block text-gray-700">Nama Mahasiswa</label>
                <input required type="text" id="nama-mahasiswa" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Cari Nama Mahasiswa...">
                <input type="hidden" name="data_mahasiswa" id="id-mahasiswa">
                <div id="mahasiswa-search-results" class="absolute w-full bg-white shadow-md rounded-lg mt-1 z-50 hidden"></div>
            </div>
            
            <div class="space-y-6 mt-6">
                <div>
                    <label for="nim" class="block text-gray-700">NIM</label>
                    <input required type="number" id="nim" name="nim" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="NIM Mahasiswa" readonly>
                </div>
                
                <div>
                    <label for="program_studi" class="block text-gray-700">Program Studi</label>
                    <input required type="text" id="program_studi" name="program_studi" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Program Studi Mahasiswa" readonly>
                </div>
            </div>
            
            <div class="mt-6 relative">
                <label for="nama-dospem" class="block text-gray-700">Nama Dosen Pendamping</label>
                <input required type="text" id="nama-dospem" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Cari Nama Dosen...">
                <input type="hidden" name="data_dospen" id="id-dosen">
                <div id="dospem-search-results" class="absolute w-full bg-white shadow-md rounded-lg mt-1 z-50 hidden"></div>
            </div>
            <div class="mt-6">
                <label for="nidn" class="block text-gray-700">NIDN</label>
                <input required type="number" id="nidn" name="nidn" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="NIDN DOSEN PENDAMPING" readonly>
            </div>
            <div class="mt-6">
                <label for="surat_izin" class="block text-gray-700">Unggah Surat Tugas / Izin ( PDF )</label>
                <input required type="file" name="surat_izin" id="surat_izin" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
            </div>
            <div class="mt-6">
                <label for="sertifikat" class="block text-gray-700">Unggah Sertifikat ( PDF )</label>
                <input required type="file" name="sertifikat" id="sertifikat" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
            </div>
            <div class="mt-6">
                <label for="upp" class="block text-gray-700">Unggah FOTO UPP ( PNG/JPG/JPEG )</label>
                <input required type="file" name="upp" id="upp" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
            </div>
            <div class="mt-6">
                <label for="rekomendasi" class="block text-gray-700">Unggah Surat Rekomendasi ( PDF )</label>
                <input required type="file" name="rekomendasi" id="rekomendasi" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
            </div>
            <div class="mt-6">
                <label for="nomor_surat_tugas" class="block text-gray-700">Nomor Surat Tugas</label>
                <input required type="text" name="no_surat_tugas" id="nomor_surat_tugas" class="bg-gray-200 px-4 py-2 rounded-lg w-full" placeholder="Masukkan Nomor Surat Tugas">
            </div>
            <div class="mt-6">
                <label for="tanggal_surat_tugas" class="block text-gray-700">Tanggal Surat Tugas</label>
                <input required type="date" name="tgl_surat_tugas" id="tanggal_surat_tugas" class="bg-gray-200 px-4 py-2 rounded-lg w-full">
            </div>
            <div class="mt-6">
                <label for="keterangan" class="block text-gray-700">KETERANGAN ( OPTIONAL )</label>
                <textarea name="keterangan" id="keterangan" class="bg-gray-200 px-4 py-2 rounded-lg w-full" rows="4" cols="50"></textarea>
            </div>
            <!-- Submit Button -->
            <div class="flex justify-end mt-6">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg">Tambah Data</button>
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
                    resultsDiv.innerHTML = ''; // Clear previous results
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
                            resultsDiv.classList.add('hidden'); // Hide the results div
                        });
                    });
                });
        } else {
            document.getElementById('dospem-search-results').classList.add('hidden');
        }
    });
</script>


@endsection
