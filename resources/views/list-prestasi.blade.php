@extends('layouts.app-admin')

@section('title', 'List Prestasi')

@section('content')
<div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between my-6">
    <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:space-x-4">
        <div class="flex items-center space-x-2 bg-gray-200 text-gray-700 px-4 rounded-lg">
            <input type="month" class="bg-gray-200 text-gray-700 rounded-lg p-2 w-32" id="startMonth" name="startMonth" placeholder="Start Month">
            <span>s/d</span>
            <input type="month" class="bg-gray-200 text-gray-700 rounded-lg p-2 w-32" id="endMonth" name="endMonth" placeholder="End Month">
        </div>

        <select class="bg-gray-200 px-4 py-2 rounded-lg" id="facultyFilter">
            <option value="">Fakultas</option>
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}">{{ $faculty->name_faculty }}</option>
            @endforeach
        </select>

        <select class="bg-gray-200 px-4 py-2 rounded-lg" id="categoryFilter">
            <option value="">Kategori</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->kategori }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:space-x-4">
        <a id="downloadExcel" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:cursor-pointer">
            Download Excel
        </a>
        <div class="relative">
            <input type="text" class="bg-gray-200 px-4 py-2 rounded-lg" id="searchBar" placeholder="Search by NIM, Name, Dosen, or NIDN...">
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow-md overflow-x-auto">
    <table class="min-w-full text-sm">
        <thead class="bg-purple-600 text-white">
            <tr>
                <th class="py-3 px-4 text-center">NO</th>
                <th class="py-3 px-4 text-center">MAHASISWA</th>
                <th class="py-3 px-4 text-center">NIM</th>
                <th class="py-3 px-4 text-center">PRODI</th>
                <th class="py-3 px-4 text-center">KEGIATAN</th>
                <th class="py-3 px-4 text-center">KATEGORI</th>
                <th class="py-3 px-4 text-center">CAPAIAN</th>
                <th class="py-3 px-4 text-center">TANGGAL</th>
                <th class="py-3 px-4 text-center">DOSEN</th>
                <th class="py-3 px-4 text-center">LAMPIRAN</th>
                <th class="py-3 px-4 text-center">ACTION</th>
            </tr>
        </thead>
        <tbody class="text-gray-700" id="prestasiTableBody">
            <tr>
                <td colspan="11" class="py-6 text-center text-gray-500">Memuat data...</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="mt-4 px-4 flex justify-between items-center">
    <div class="flex items-center space-x-2" id="paginationLinks"></div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startMonth = document.getElementById('startMonth');
        const endMonth = document.getElementById('endMonth');
        const facultyFilter = document.getElementById('facultyFilter');
        const categoryFilter = document.getElementById('categoryFilter');
        const searchBar = document.getElementById('searchBar');
        const downloadExcelButton = document.getElementById('downloadExcel');
        const prestasiTableBody = document.getElementById('prestasiTableBody');
        const paginationLinks = document.getElementById('paginationLinks');

        function buildExportUrl() {
            const filtersApplied = startMonth.value || endMonth.value || facultyFilter.value || categoryFilter.value || searchBar.value;

            if (filtersApplied) {
                const query = new URLSearchParams({
                    startMonth: startMonth.value,
                    endMonth: endMonth.value,
                    faculty_id: facultyFilter.value,
                    category_id: categoryFilter.value,
                    search: searchBar.value
                }).toString();

                downloadExcelButton.href = `{{ route('export-prestasi') }}?${query}`;
            } else {
                downloadExcelButton.href = `{{ route('export-prestasi') }}`;
            }
        }

        function fetchPrestasi(page = 1) {
            const query = {
                startMonth: startMonth.value,
                endMonth: endMonth.value,
                faculty_id: facultyFilter.value,
                category_id: categoryFilter.value,
                search: searchBar.value,
                page: page
            };

            fetch('{{ route('get-prestasi') }}?' + new URLSearchParams(query))
                .then(response => response.json())
                .then(data => {
                    prestasiTableBody.innerHTML = '';

                    if (!data.prestasi || data.prestasi.length === 0) {
                        prestasiTableBody.innerHTML = '<tr><td colspan="11" class="text-center py-6 text-gray-500">No data available</td></tr>';
                    } else {
                        data.prestasi.forEach((p, index) => {
                            const mahasiswa = p.mahasiswa || {};
                            const prodi = mahasiswa.prodi || {};
                            const dosen = p.dosen_pembimbing || {};
                            const kategori = p.kategori || {};
                            const capaian = p.capaian || {};
                            const fileUpload = p.file_upload || {};

                            const detailUrl = `{{ url('/prestasi') }}/${p.id}`;
                            const uppUrl = fileUpload.url_upp ? `{{ asset('storage') }}/${fileUpload.url_upp}` : '';
                            const lampiranHtml = uppUrl
                                ? `<a href="${detailUrl}#lampiran" class="inline-flex items-center justify-center">
                                        <img src="${uppUrl}" alt="UPP" class="h-10 w-10 rounded object-cover" />
                                   </a>`
                                : `<a href="${detailUrl}#lampiran" class="text-purple-600 hover:underline">Lihat</a>`;

                            const tanggal = p.tanggal_mulai && p.tanggal_selesai
                                ? `${p.tanggal_mulai} - ${p.tanggal_selesai}`
                                : (p.tanggal_mulai || p.tanggal_selesai || '-');

                            prestasiTableBody.innerHTML += `
                                <tr class="border-b border-gray-200">
                                    <td class="py-3 px-4 text-center">${index + 1}</td>
                                    <td class="py-3 px-4 text-center">${mahasiswa.nama || '-'}</td>
                                    <td class="py-3 px-4 text-center">${mahasiswa.NIM || '-'}</td>
                                    <td class="py-3 px-4 text-center">${prodi.study_program || '-'}</td>
                                    <td class="py-3 px-4 text-center">${p.nama_kegiatan || '-'}</td>
                                    <td class="py-3 px-4 text-center">${kategori.kategori || '-'}</td>
                                    <td class="py-3 px-4 text-center">${capaian.jenis_juara || '-'}</td>
                                    <td class="py-3 px-4 text-center">${tanggal}</td>
                                    <td class="py-3 px-4 text-center">${dosen.nama || '-'}</td>
                                    <td class="py-3 px-4 text-center">${lampiranHtml}</td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="inline-flex flex-wrap items-center justify-center gap-2">
                                            <a href="${detailUrl}" class="rounded-lg bg-purple-600 px-3 py-1 text-xs font-semibold text-white hover:bg-purple-700">Detail</a>
                                            <a href="{{ url('/prestasi') }}/${p.id}/edit" class="rounded-lg bg-yellow-500 px-3 py-1 text-xs font-semibold text-white hover:bg-yellow-600">Edit</a>
                                            <form action="{{ url('/prestasi') }}/${p.id}" method="POST" onsubmit="return confirm('Hapus data ini?');" class="inline-block">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="rounded-lg bg-red-500 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>`;
                        });
                    }

                    paginationLinks.innerHTML = data.pagination || '';
                })
                .catch(error => console.error('Error fetching prestasi:', error));
        }

        startMonth.addEventListener('change', () => { buildExportUrl(); fetchPrestasi(1); });
        endMonth.addEventListener('change', () => { buildExportUrl(); fetchPrestasi(1); });
        facultyFilter.addEventListener('change', () => { buildExportUrl(); fetchPrestasi(1); });
        categoryFilter.addEventListener('change', () => { buildExportUrl(); fetchPrestasi(1); });
        searchBar.addEventListener('input', () => { buildExportUrl(); fetchPrestasi(1); });

        document.addEventListener('click', function (event) {
            if (event.target.matches('.pagination-link')) {
                event.preventDefault();
                const page = event.target.dataset.page;
                fetchPrestasi(page);
            }
        });

        buildExportUrl();
        fetchPrestasi();
    });
</script>
@endsection
