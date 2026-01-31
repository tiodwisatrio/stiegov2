@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Create Testimonial</h2>
        <a href="{{ route('admin.testimonials.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to List
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Testimonial Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="testimonial_name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="testimonial_name" id="testimonial_name" value="{{ old('testimonial_name') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('testimonial_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="testimonial_position" class="block text-sm font-medium text-gray-700">Position / Role</label>
                <input type="text" name="testimonial_position" id="testimonial_position" value="{{ old('testimonial_position') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('testimonial_position')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Rating -->
        <div>
            <label for="testimonial_rating" class="block text-sm font-medium text-gray-700">Rating</label>
            <select name="testimonial_rating" id="testimonial_rating"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">Select Rating</option>
                @for($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('testimonial_rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                @endfor
            </select>
            @error('testimonial_rating')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description -->
        <div>
            <label for="testimonial_description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="testimonial_description" id="testimonial_description" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                placeholder="Write testimonial description...">{{ old('testimonial_description') }}</textarea>
            @error('testimonial_description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Testimonial Image</label>
            
            <div id="imagePreviewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>

            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                              stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="testimonial_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                            <span>Upload file</span>
                            <input id="testimonial_image" name="testimonial_image" type="file" class="sr-only" accept="image/*">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-indigo-700">
                Create Testimonial
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('testimonial_image');
    const previewContainer = document.getElementById('imagePreviewContainer');

    input.addEventListener('change', () => {
        previewContainer.innerHTML = '';
        const file = input.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.className = 'relative group border rounded-lg overflow-hidden';
                div.style.paddingBottom = '100%';
                div.innerHTML = `
                    <img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover">
                    <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100" onclick="this.parentElement.remove();input.value=''">
                        ✕
                    </button>`;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
@endsection
