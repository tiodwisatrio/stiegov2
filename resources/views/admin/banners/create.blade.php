@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Create Banner</h2>
        <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Banner Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="banner_title" class="block text-sm font-medium text-gray-700">Banner Title <span class="text-red-500">*</span></label>
                <input type="text" name="banner_title" id="banner_title" value="{{ old('banner_title') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('banner_title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="banner_type" class="block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
                <select name="banner_type" id="banner_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Select Type</option>
                    <option value="image" {{ old('banner_type') == 'image' ? 'selected' : '' }}>Image</option>
                    <option value="video" {{ old('banner_type') == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>
        </div>

        <!-- Subtitle & Description -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="banner_subtitle" class="block text-sm font-medium text-gray-700">Subtitle (Optional)</label>
                <input type="text" name="banner_subtitle" id="banner_subtitle" value="{{ old('banner_subtitle') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="banner_description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                <textarea name="banner_description" id="banner_description" rows="2"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('banner_description') }}</textarea>
            </div>
        </div>

        <!-- Image / Video Input -->
        <div id="imageField" class="{{ old('banner_type') == 'video' ? 'hidden' : '' }}">
            <label for="banner_image" class="block text-sm font-medium text-gray-700">Banner Image</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="banner_image_input" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                            <span>Upload Image</span>
                            <input id="banner_image_input" name="banner_image" type="file" class="sr-only" accept="image/*">
                        </label>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                </div>
            </div>
            <div id="imagePreview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
        </div>

        <!-- Video URL -->
        <div id="videoField" class="{{ old('banner_type') == 'image' || !old('banner_type') ? 'hidden' : '' }}">
            <label for="banner_video_url" class="block text-sm font-medium text-gray-700">Video URL</label>
            <input type="text" name="banner_video_url" id="banner_video_url" value="{{ old('banner_video_url') }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="https://youtu.be/... atau link video">
        </div>

        <!-- Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="banner_status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="banner_status" id="banner_status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="1" {{ old('banner_status') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('banner_status') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-indigo-700">
                Create Banner
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const bannerType = document.getElementById('banner_type');
    const imageField = document.getElementById('imageField');
    const videoField = document.getElementById('videoField');
    const imageInput = document.getElementById('banner_image_input');
    const preview = document.getElementById('imagePreview');

    // toggle fields
    bannerType.addEventListener('change', () => {
        if (bannerType.value === 'video') {
            imageField.classList.add('hidden');
            videoField.classList.remove('hidden');
        } else {
            videoField.classList.add('hidden');
            imageField.classList.remove('hidden');
        }
    });

    // preview image
    imageInput.addEventListener('change', () => {
        preview.innerHTML = '';
        Array.from(imageInput.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'relative group border rounded-lg overflow-hidden';
                div.style.paddingBottom = '100%';
                div.innerHTML = `
                    <img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover">
                    <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100" onclick="this.parentElement.remove()">
                        ✕
                    </button>`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>
@endpush
@endsection
