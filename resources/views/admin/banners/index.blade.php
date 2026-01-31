@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Banners</h2>
        <a href="{{ route('admin.banners.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-xs font-semibold uppercase hover:bg-indigo-700">
            + Create Banner
        </a>
    </div>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Preview</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Title</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($banners as $banner)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $loop->iteration }}</td>

                        <td class="px-4 py-3">
                            @if ($banner->banner_type === 'image' && $banner->banner_image)
                                <img src="{{ asset('storage/'.$banner->banner_image) }}" class="h-14 w-28 object-cover rounded-md">
                            @elseif ($banner->banner_type === 'video')
                                <span class="text-sm text-gray-500">🎬 Video</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $banner->banner_title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ ucfirst($banner->banner_type) }}</td>
                        <td class="px-4 py-3">
                            @if ($banner->banner_status)
                                <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Active</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Inactive</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                   class="px-2 py-1 text-xs text-blue-600 border border-blue-500 rounded hover:bg-blue-50">
                                    Edit
                                </a>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this banner?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-2 py-1 text-xs text-red-600 border border-red-500 rounded hover:bg-red-50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No banners found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
