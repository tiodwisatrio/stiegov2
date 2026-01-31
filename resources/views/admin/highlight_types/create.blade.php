@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Create Highlight Type</h1>
            <a href="{{ route('admin.highlight-types.index') }}"
               class="text-gray-600 hover:text-gray-900">
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('admin.highlight-types.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                    <input type="text"
                           name="name"
                           id="name"
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="mb-4">
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text"
                           name="slug"
                           id="slug"
                           value="{{ old('slug') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                           placeholder="Leave empty to auto-generate from name">
                    @error('slug')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Used in URLs (e.g., /catalog/ramadhan-series)</p>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description"
                              id="description"
                              rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Banner Desktop -->
                <div class="mb-4">
                    <label for="banner_desktop" class="block text-sm font-medium text-gray-700 mb-2">Banner Desktop (16:9)</label>
                    <input type="file"
                           name="banner_desktop"
                           id="banner_desktop"
                           accept="image/*"
                           onchange="previewImage(this, 'preview_desktop')"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('banner_desktop') border-red-500 @enderror">
                    @error('banner_desktop')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Recommended: 1920x1080px (16:9 ratio). Max 2MB.</p>

                    <!-- Preview Desktop -->
                    <div id="preview_desktop" class="mt-3 hidden">
                        <img src="" alt="Desktop banner preview" class="w-full max-w-2xl h-auto rounded-lg border">
                    </div>
                </div>

                <!-- Banner Mobile -->
                <div class="mb-4">
                    <label for="banner_mobile" class="block text-sm font-medium text-gray-700 mb-2">Banner Mobile (9:16 or 1:1)</label>
                    <input type="file"
                           name="banner_mobile"
                           id="banner_mobile"
                           accept="image/*"
                           onchange="previewImage(this, 'preview_mobile')"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('banner_mobile') border-red-500 @enderror">
                    @error('banner_mobile')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Recommended: 1080x1920px (9:16) or 1080x1080px (1:1). Max 2MB.</p>

                    <!-- Preview Mobile -->
                    <div id="preview_mobile" class="mt-3 hidden">
                        <img src="" alt="Mobile banner preview" class="w-auto max-w-xs h-64 object-cover rounded-lg border">
                    </div>
                </div>

                <!-- Display Order -->
                <div class="mb-4">
                    <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                    <input type="number"
                           name="display_order"
                           id="display_order"
                           value="{{ old('display_order', 0) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('display_order') border-red-500 @enderror">
                    @error('display_order')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                </div>

                <!-- Is Active -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox"
                               name="is_active"
                               id="is_active"
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Active</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4">
                    <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition">
                        Create Highlight Type
                    </button>
                    <a href="{{ route('admin.highlight-types.index') }}"
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    const img = preview.querySelector('img');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        img.src = '';
        preview.classList.add('hidden');
    }
}
</script>
@endsection
