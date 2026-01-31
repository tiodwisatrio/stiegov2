@extends('layouts.admin')

@section('content')
    <div class="container mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold text-gray-900">Edit Category</h1>
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')
                
                <!-- Category Name -->
                <div class="mb-6">
                    <label for="category_name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" name="category_name" id="category_name" value="{{ old('category_name', $category->category_name) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('category_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Slug -->
                <div class="mb-6">
                    <label for="category_slug" class="block text-sm font-medium text-gray-700">Category Slug</label>
                    <input type="text" name="category_slug" id="category_slug" value="{{ old('category_slug', $category->category_slug) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('category_slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div class="mb-6">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category (Optional)</label>
                    <select name="parent_id" id="parent_id" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Main Category --</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" 
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                {{ $parent->category_name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Leave empty for main category, or select parent for sub-category</p>
                    @error('parent_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Update Category
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Slug Generator Script -->
    <script>
        const nameInput = document.getElementById('category_name');
        const slugInput = document.getElementById('category_slug');
        let originalSlug = slugInput.value;

        nameInput.addEventListener('input', function() {
            // Only update slug if it hasn't been manually edited
            if (slugInput.value === originalSlug) {
                slugInput.value = nameInput.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-');
                originalSlug = slugInput.value;
            }
        });
    </script>
    
@endsection