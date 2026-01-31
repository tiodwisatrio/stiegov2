@extends('layouts.frontend')

@section('content')
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            
            <!-- Bagian Kiri -->
            <div>
                <p class="text-red-600 font-semibold mb-2">Hubungi Tim Stiego</p>
                <h2 class="text-2xl md:text-3xl font-bold mb-8 leading-snug">
                    Ada pertanyaan, saran, atau mau kerja sama? Kami siap dengerin kamu!
                </h2>

                <div class="space-y-4 text-gray-700">
                    <div class="grid grid-cols-[100px_auto] md:grid-cols-[120px_auto] gap-x-2">
                        <span class="font-semibold">Email</span>
                        <span>: stiegostiego@gmail.com</span>
                    </div>
                    <div class="grid grid-cols-[100px_auto] md:grid-cols-[120px_auto] gap-x-2">
                        <span class="font-semibold">Telephone</span>
                        <span>: +62 895 2766 8283</span>
                    </div>
                    <div class="grid grid-cols-[100px_auto] md:grid-cols-[120px_auto] gap-x-2">
                        <span class="font-semibold">Alamat</span>
                        <span>: Jl. Mayor Dasuki, Jatibarang, Kec. Jatibarang, Kabupaten Indramayu, Jawa Barat 45273</span>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan (Peta / Iframe) -->
            <div class="rounded-2xl overflow-hidden shadow-lg h-[300px] md:h-[350px]">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.4352654658383!2d108.29830650803775!3d-6.466414363194161!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6ec7ceaf306545%3A0xec1cd189ceaab06a!2sSTIEGO!5e0!3m2!1sid!2sid!4v1760651230321!5m2!1sid!2sid" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full h-full">
                </iframe>
            </div>

        </div>
    </div>
</section>
@endsection
