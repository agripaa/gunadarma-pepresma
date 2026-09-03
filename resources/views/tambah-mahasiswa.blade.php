@extends('layouts.app-admin')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="container mx-auto p-6 space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Data Mahasiswa</h1>
            <p class="text-sm text-gray-500">Kelola data mahasiswa Gunadarma.</p>
        </div>
        <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
            <form method="GET" action="{{ route('mahasiswa.index') }}" class="w-full sm:w-64">
                <input type="text" name="search" placeholder="Cari nama atau NIM" value="{{ $search ?? '' }}" class="w-full rounded-lg bg-gray-200 px-4 py-2 text-sm">
            </form>
            <button type="button" data-open-create-mahasiswa class="inline-flex items-center justify-center rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white hover:bg-purple-700">
                Tambah Mahasiswa
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
        @if($mahasiswa->isEmpty())
            <p class="px-6 py-6 text-gray-600">Belum ada data mahasiswa.</p>
        @else
            <table class="w-full border-collapse text-sm">
                <thead class="bg-purple-600 text-white">
                    <tr>
                        <th class="py-3 px-4 text-center">No</th>
                        <th class="py-3 px-4 text-center">Nama</th>
                        <th class="py-3 px-4 text-center">NIM</th>
                        <th class="py-3 px-4 text-center">Program Studi</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mahasiswa as $mhs)
                        <tr class="border-b">
                            <td class="py-3 px-4 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 text-center">{{ $mhs->nama }}</td>
                            <td class="py-3 px-4 text-center">{{ $mhs->NIM }}</td>
                            <td class="py-3 px-4 text-center">{{ $mhs->prodi->study_program }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="inline-flex items-center gap-2">
                                    <button
                                        type="button"
                                        data-open-edit-mahasiswa
                                        data-id="{{ $mhs->id }}"
                                        data-nama="{{ $mhs->nama }}"
                                        data-nim="{{ $mhs->NIM }}"
                                        data-faculty="{{ $mhs->faculty }}"
                                        data-prodi="{{ $mhs->prodi_id }}"
                                        class="text-sm font-semibold text-blue-600 hover:text-blue-800"
                                    >
                                        Edit
                                    </button>
                                    <form action="{{ route('mahasiswa.destroy', $mhs->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800" onclick="return confirm('Hapus data ini?')">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="border-t px-6 py-4">
                {{ $mahasiswa->links() }}
            </div>
        @endif
    </div>
</div>

<div id="modalMahasiswaCreate" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-2xl rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">Tambah Mahasiswa</h3>
            <button type="button" data-close-modal="modalMahasiswaCreate" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <form action="{{ route('mahasiswa.store') }}" method="POST" class="space-y-4 px-6 py-5">
            @csrf
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="create_nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="create_nama" name="nama" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="create_nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="create_nim" name="NIM" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label for="create_faculty" class="block text-sm font-medium text-gray-700">Fakultas</label>
                <select id="create_faculty" name="faculty_id" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Pilih Fakultas</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name_faculty }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="create_prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                <select id="create_prodi" name="prodi_id" disabled required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Pilih Program Studi</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" data-close-modal="modalMahasiswaCreate" class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit" class="rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white hover:bg-purple-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalMahasiswaEdit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">
    <div class="w-full max-w-2xl rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b px-6 py-4">
            <h3 class="text-lg font-semibold text-gray-800">Edit Mahasiswa</h3>
            <button type="button" data-close-modal="modalMahasiswaEdit" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <form id="formMahasiswaEdit" method="POST" data-update-url="{{ url('/mahasiswa') }}" class="space-y-4 px-6 py-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="edit_nama" class="block text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="edit_nama" name="nama" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="edit_nim" class="block text-sm font-medium text-gray-700">NIM</label>
                    <input type="text" id="edit_nim" name="NIM" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                </div>
            </div>
            <div>
                <label for="edit_faculty" class="block text-sm font-medium text-gray-700">Fakultas</label>
                <select id="edit_faculty" name="faculty_id" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Pilih Fakultas</option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->id }}">{{ $faculty->name_faculty }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="edit_prodi" class="block text-sm font-medium text-gray-700">Program Studi</label>
                <select id="edit_prodi" name="prodi_id" required class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">Pilih Program Studi</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" data-close-modal="modalMahasiswaEdit" class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-semibold text-gray-600 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit" class="rounded-lg bg-purple-600 px-4 py-2 text-sm font-semibold text-white hover:bg-purple-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const modalCreateMahasiswa = document.getElementById('modalMahasiswaCreate');
    const modalEditMahasiswa = document.getElementById('modalMahasiswaEdit');
    const editMahasiswaForm = document.getElementById('formMahasiswaEdit');

    function openModal(modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal(modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.querySelector('[data-open-create-mahasiswa]').addEventListener('click', () => {
        openModal(modalCreateMahasiswa);
    });

    document.querySelectorAll('[data-close-modal]').forEach((button) => {
        button.addEventListener('click', () => {
            const targetId = button.dataset.closeModal;
            const target = document.getElementById(targetId);
            if (target) {
                closeModal(target);
            }
        });
    });

    [modalCreateMahasiswa, modalEditMahasiswa].forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal(modal);
            }
        });
    });

    const createFaculty = document.getElementById('create_faculty');
    const createProdi = document.getElementById('create_prodi');
    const editFaculty = document.getElementById('edit_faculty');
    const editProdi = document.getElementById('edit_prodi');

    function loadProdiOptions(facultyId, targetSelect, selectedId = null) {
        if (!facultyId) {
            targetSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
            targetSelect.disabled = true;
            return;
        }

        targetSelect.disabled = true;
        fetch(`{{ url('/get-prodi-by-faculty') }}/${facultyId}`)
            .then(response => response.json())
            .then(data => {
                targetSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                data.forEach((prodi) => {
                    const option = document.createElement('option');
                    option.value = prodi.id;
                    option.textContent = prodi.study_program;
                    if (selectedId && String(selectedId) === String(prodi.id)) {
                        option.selected = true;
                    }
                    targetSelect.appendChild(option);
                });
                targetSelect.disabled = false;
            })
            .catch(() => {
                targetSelect.innerHTML = '<option value="">Pilih Program Studi</option>';
                targetSelect.disabled = true;
            });
    }

    createFaculty.addEventListener('change', (event) => {
        loadProdiOptions(event.target.value, createProdi);
    });

    editFaculty.addEventListener('change', (event) => {
        loadProdiOptions(event.target.value, editProdi);
    });

    document.querySelectorAll('[data-open-edit-mahasiswa]').forEach((button) => {
        button.addEventListener('click', () => {
            const id = button.dataset.id;
            editMahasiswaForm.action = `${editMahasiswaForm.dataset.updateUrl}/${id}`;
            document.getElementById('edit_nama').value = button.dataset.nama || '';
            document.getElementById('edit_nim').value = button.dataset.nim || '';
            editFaculty.value = button.dataset.faculty || '';
            loadProdiOptions(button.dataset.faculty, editProdi, button.dataset.prodi);
            openModal(modalEditMahasiswa);
        });
    });
</script>
@endsection
