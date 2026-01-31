@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between mb-4">
            <h2 class="text-2xl font-semibold">Categories</h2>
            <a href="{{ route('admin.categories.create') }}" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Add New</a>
        </div>
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Slug</th>
                    <th class="px-4 py-2 text-left">Type</th>
                    <th class="px-4 py-2 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <!-- Parent Category -->
                    <tr class="bg-gray-50 font-semibold hover:bg-gray-100 transition-colors">
                        <td class="border px-4 py-2">
                            <div class="flex items-center">
                                <span class="text-gray-700">{{ $category->category_name }}</span>
                                @if($category->children->count() > 0)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 text-xs font-medium text-gray-600 bg-gray-200 rounded-full">
                                        {{ $category->children->count() }} sub
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 text-xs font-normal text-amber-600 bg-amber-50 rounded-full">
                                        No sub-categories
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="border px-4 py-2">{{ $category->category_slug }}</td>
                        <td class="border px-4 py-2">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded">
                                Main Category
                            </span>
                        </td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Parent Edit Button - Solid Style -->
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                
                                <!-- Parent Delete Button - Solid Style with Warning -->
                               <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline delete-form" data-name="{{ $category->category_name }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Sub-Categories -->
                    @foreach($category->children as $child)
                        <tr class="bg-white hover:bg-gray-50 transition-colors">
                            <td class="border px-4 py-2 pl-12">
                                <span class="text-gray-400">└─</span> {{ $child->category_name }}
                            </td>
                            <td class="border px-4 py-2">{{ $child->category_slug }}</td>
                            <td class="border px-4 py-2">
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded">
                                    Sub-category of: {{ $category->category_name }}
                                </span>
                            </td>
                            <td class="border px-4 py-2 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <!-- Sub-category Edit - Text Link Style (Lighter) -->
                                    <a href="{{ route('admin.categories.edit', $child) }}" 
                                       class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 hover:underline font-normal">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    <!-- Sub-category Delete - Text Link Style (Lighter) -->
                                    <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" class="inline delete-form" data-name="{{ $child->category_name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center text-sm text-red-600 hover:text-red-800 hover:underline font-normal">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $categories->links() }}
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                const categoryName = form.getAttribute('data-name');
                const confirmed = confirm(`⚠️ Are you sure you want to delete the category: "${categoryName}"?\n\nThis action cannot be undone.`);

                if (!confirmed) {
                    e.preventDefault(); // Cancel form submission
                }
            });
        });
    });
</script>
@endsection