@extends('layouts.app-admin')

@section('title', 'List Admin')

@section('content')
<!-- Add Admin Button and Search Bar -->
<div class="flex items-center justify-between my-6">
    <a href="{{ route('create') }}" class="bg-gray-200 px-4 py-2 rounded-lg font-semibold">Tambahkan Admin</a>

    <!-- Search Form -->
    <form action="{{ route('admin.search') }}" method="GET">
        <input type="text" name="query" class="bg-gray-200 px-4 py-2 rounded-lg" placeholder="username or email..." value="{{ request('query') }}">
        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4m0 0l4 4m-4-4V4m0 0H4" />
            </svg>
        </button>
    </form>
</div>

<!-- Table -->
<div class="overflow-x-auto bg-white rounded-lg shadow-md">
    <table class="min-w-full bg-white">
        <thead class="bg-purple-600 text-white">
            <tr>
                <th class="py-3 px-6 text-center">NO</th>
                <th class="py-3 px-6 text-center">USERNAME</th>
                <th class="py-3 px-6 text-center">EMAIL</th>
                <th class="py-3 px-6 text-center">ACTION</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">
            @if($admins->isEmpty())
                <tr>
                    <td colspan="4" class="py-3 px-6 text-center">No admin found</td>
                </tr>
            @else
                @foreach($admins as $index => $admin)
                <tr class="border-b border-gray-300">
                    <td class="py-3 px-6 text-center">{{ $index + 1 }}</td>
                    <td class="py-3 px-6 text-center">{{ $admin->username }}</td>
                    <td class="py-3 px-6 text-center">{{ $admin->email }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <!-- Edit Admin -->
                            <a href="{{ route('admin.edit', $admin->id) }}" class="bg-blue-100 hover:bg-blue-200 rounded-full p-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </a>

                            <!-- Delete Admin -->
                            <form action="{{ route('admin.delete', $admin->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-100 hover:bg-red-200 rounded-full p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
