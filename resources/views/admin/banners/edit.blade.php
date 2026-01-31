@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Banner</h2>
        <a href="{{ route('admin.banners.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <label for="banner_title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
            <input type="text" name="banner_title" id="banner_title" value="{{ old('banner_title', $banner->banner_title) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required>
            @error('banner_title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Subtitle & Description -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="banner_subtitle" class="block text-sm font-medium text-gray-700">Subtitle</label>
                <input type="text" name="banner_subtitle" id="banner_subtitle" value="{{ old('banner_subtitle', $banner->banner_subtitle) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Optional">
            </div>
            <div>
                <label for="banner_description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="banner_description" id="banner_description" rows="2"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Optional">{{ old('banner_description', $banner->banner_description) }}</textarea>
            </div>
        </div>

        <!-- Type & Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="banner_type" class="block text-sm font-medium text-gray-700">Banner Type <span class="text-red-500">*</span></label>
                <select name="banner_type" id="banner_type"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">Select Type</option>
                    <option value="image" {{ old('banner_type', $banner->banner_type) == 'image' ? 'selected' : '' }}>Image</option>
                    <option value="video" {{ old('banner_type', $banner->banner_type) == 'video' ? 'selected' : '' }}>Video</option>
                </select>
            </div>

            <div>
                <label for="banner_status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="banner_status" id="banner_status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="1" {{ old('banner_status', $banner->banner_status) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('banner_status', $banner->banner_status) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <!-- Image Upload -->
        <div id="image-section" class="{{ old('banner_type', $banner->banner_type) == 'video' ? 'hidden' : '' }}">
            <label class="block text-sm font-medium text-gray-700 mb-2">Banner Image</label>

            <!-- Image Preview -->
            <div id="imagePreviewContainer" class="mb-4">
                @if($banner->banner_image)
                    <img src="{{ asset('storage/' . $banner->banner_image) }}" id="imagePreview" class="w-64 rounded-md shadow">
                @else
                    <p class="text-sm text-gray-500">No image uploaded yet.</p>
                @endif
            </div>

            <!-- Upload -->
            <input type="file" name="banner_image" id="banner_image" accept="image/*"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP up to 2MB</p>
        </div>

        <!-- Video Upload -->
        <div id="video-section" class="{{ old('banner_type', $banner->banner_type) == 'image' ? 'hidden' : '' }}">
            <label for="banner_video_url" class="block text-sm font-medium text-gray-700">Video URL</label>
            <input type="text" name="banner_video_url" id="banner_video_url"
                value="{{ old('banner_video_url', $banner->banner_video_url) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="https://example.com/video.mp4">

            @if($banner->banner_video_url)
                <div class="mt-3">
                    <video controls class="w-64 rounded-md shadow">
                        <source src="{{ $banner->banner_video_url }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            @endif
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-indigo-700">
                Update Banner
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const bannerType = document.getElementById('banner_type');
    const imageSection = document.getElementById('image-section');
    const videoSection = document.getElementById('video-section');
    const imageInput = document.getElementById('banner_image');
    const imagePreview = document.getElementById('imagePreview');

    // Toggle between image & video sections
    bannerType.addEventListener('change', () => {
        if (bannerType.value === 'image') {
            imageSection.classList.remove('hidden');
            videoSection.classList.add('hidden');
        } else if (bannerType.value === 'video') {
            videoSection.classList.remove('hidden');
            imageSection.classList.add('hidden');
        } else {
            imageSection.classList.add('hidden');
            videoSection.classList.add('hidden');
        }
    });

    // Preview new image instantly
    imageInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = e => {
            let previewEl = document.getElementById('imagePreview');
            if (!previewEl) {
                previewEl = document.createElement('img');
                previewEl.id = 'imagePreview';
                previewEl.className = 'w-64 rounded-md shadow';
                document.getElementById('imagePreviewContainer').innerHTML = '';
                document.getElementById('imagePreviewContainer').appendChild(previewEl);
            }
            previewEl.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
@endsection
