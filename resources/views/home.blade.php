@extends('layouts.app')

@section('content')
<section class="flex w-full items-center justify-center h-screen">
    <div class="flex w-full h-full justify-center items-center">
        <img src={{ asset("images/wellcome.png") }} class="w-full mt-16" alt="Welcome">
    </div>
</section>

<section class="bg-white min-h-screen flex flex-col items-center justify-center" id="prestasi">
    <div class="text-center mb-10">
        <h1 class="text-6xl font-bold text-gray-900">Prestasi Mahasiswa Universitas Gunadarma</h1>
    </div>
    <div class="container mx-auto px-4">

        <!-- Filter and Search -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <select id="facultyFilter" class="border border-gray-300 rounded-lg px-4 py-2">
                    <option value="">Fakultas</option>
                    @foreach($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name_faculty }}</option>
                    @endforeach
                </select>
            </div>
            <div class="relative">
                <input id="searchInput" type="text" class="border border-gray-300 rounded-lg px-4 py-2" placeholder="Search by NIM or Name...">
            </div>
        </div>

        <!-- Tabel Prestasi -->
        <div class="border border-gray-300 rounded-lg overflow-x-auto">
            <div class="max-h-[500px] overflow-y-auto">
                <table class="min-w-full h-full bg-white">
                    <thead class="bg-purple-600 text-white sticky top-0">
                        <tr>
                            <th class="py-3 px-6 text-center">NO</th>
                            <th class="py-3 px-6 text-center">NIM</th>
                            <th class="py-3 px-6 text-center">NAMA</th>
                            <th class="py-3 px-6 text-center">PRODI</th>
                            <th class="py-3 px-6 text-center">KEGIATAN</th>
                            <th class="py-3 px-6 text-center">CAPAIAN PRESTASI</th>
                            <th class="py-3 px-6 text-center">LAMPIRAN</th>
                        </tr>
                    </thead>
                    <tbody id="prestasiTable">
                        <!-- Data prestasi will be inserted here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex justify-end">
            <div id="paginationLinks">
                <!-- Pagination links will be inserted here -->
            </div>
        </div>
    </div>
</section>

<section class="bg-white flex items-center justify-center" id="contact">
    <div class="container mx-auto px-4">
        <div class="text-left mb-10">
            <h2 class="text-7xl font-bold text-gray-900">Contact Us!</h2>
            <span class="block w-[17rem] border-b-2 border-purple-600 ml-1 mt-2"></span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
            <div class="w-full flex justify-center">
                <img src="{{ asset('images/contact.png') }}" alt="Contact Us" class="max-w-lg">
            </div>

            <div>
                <p class="text-gray-600 text-lg font-semibold w-10/12 mb-6">Jika ada yang perlu di tanyakan kami siap untuk membantu, silahkan hubungi :</p>
                <ul class="text-gray-900 space-y-4">
                    <li><strong>Alamat:</strong> {{ $contact->alamat ?? 'N/A' }}</li>
                    <li><strong>Telepon:</strong> {{ $contact->no_telepon ?? 'N/A' }}</li>
                    <li><strong>Email:</strong> {{ $contact->email ?? 'N/A' }}</li>
                </ul>
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center mt-10">
                    @if ($contact && $contact->map_embed)
                        <iframe src="{{ $contact->map_embed }}" width="700" height="256" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <p>No map available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const facultyFilter = document.getElementById('facultyFilter');
    const searchInput = document.getElementById('searchInput');
    const prestasiTable = document.getElementById('prestasiTable');
    const paginationLinks = document.getElementById('paginationLinks');

    // Function to fetch and update prestasi data
    function fetchPrestasi(faculty = '', search = '', page = 1) {
        const url = `{{ route('get-prestasi') }}?faculty_id=${faculty}&search=${search}&page=${page}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Clear the existing table content
                prestasiTable.innerHTML = '';

                // Populate the table with new data
                data.prestasi.forEach((prestasi, index) => {
                    const newRow = `
                        <tr class="border-b border-gray-300">
                            <td class="py-4 px-6 text-center">${index + 1}</td>
                            <td class="py-4 px-6 text-center">${prestasi.mahasiswa.NIM}</td>
                            <td class="py-4 px-6 text-center">${prestasi.mahasiswa.nama}</td>
                            <td class="py-4 px-6 text-center">${prestasi.mahasiswa.prodi.study_program}</td>
                            <td class="py-4 px-6 text-center">${prestasi.nama_kegiatan}</td>
                            <td class="py-4 px-6 text-center">${prestasi.capaian.jenis_juara}</td>
                            <td class="py-4 px-6 text-center">
                                ${prestasi.file_upload ? `<a class="px-4 py-2 bg-purple-600 hover:bg-purple-700 rounded-2xl text-gray-100 font-semibold" href="{{ asset('storage') }}/${prestasi.file_upload.url_certificate}" target="_blank">View Certificate</a>` : 'No Lampiran'}
                            </td>
                        </tr>
                    `;
                    prestasiTable.innerHTML += newRow;
                });

                // Update pagination links
                paginationLinks.innerHTML = data.pagination;
            })
            .catch(error => console.error('Error fetching prestasi:', error));
    }

    // Fetch prestasi when the page loads
    fetchPrestasi();

    // Fetch prestasi when the faculty filter or search input changes
    facultyFilter.addEventListener('change', function () {
        fetchPrestasi(facultyFilter.value, searchInput.value);
    });

    searchInput.addEventListener('input', function () {
        fetchPrestasi(facultyFilter.value, searchInput.value);
    });

    // Handle pagination click events
    document.addEventListener('click', function (event) {
        if (event.target.matches('.pagination-link')) {
            event.preventDefault();
            const page = event.target.dataset.page;
            fetchPrestasi(facultyFilter.value, searchInput.value, page);
        }
    });
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

</script>
@endsection

