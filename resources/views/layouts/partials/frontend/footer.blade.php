<footer class="px-5 bg-white">
  <div class="footer-section max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col md:flex-row justify-between items-stretch gap-8">
      <!-- Company Info -->
      <div class="space-y-4 md:w-1/4 text-sm flex-1 flex flex-col">
        <img src="{{ asset('images/logo_stiego.png') }}" alt="Stiego Logo" class="w-16">
        <p class="text-gray-600 text-sm flex-grow">
          Stiego store adalah toko pakaian multibrand atau tempat yang menjual pakaian jadi wanita & pria dewasa seperti baju, celana, hijab, dan produk tekstil lainnya yang dikenakan manusia.
        </p>
      </div>

      <!-- Quick Links -->
      <div class="space-y-4 flex-1 flex flex-col">
        <h3 class="text-lg font-semibold">Links</h3>
        <ul class="space-y-2 flex-grow">
          <li><a href="{{ route('frontend.home') }}" class="text-gray-900 hover:text-[var(--color-hover)]">Home</a></li>
          <li><a href="{{ route('frontend.about') }}" class="text-gray-900 hover:text-[var(--color-hover)]">About</a></li>
          <li><a href="{{ route('frontend.catalog.index') }}" class="text-gray-900 hover:text-[var(--color-hover)]">Catalog</a></li>
          <li><a href="{{ route('frontend.products.index') }}" class="text-gray-900 hover:text-[var(--color-hover)]">Products</a></li>
          <li><a href="{{ route('frontend.contact') }}" class="text-gray-900 hover:text-[var(--color-hover)]">Contact</a></li>
        </ul>
      </div>

      <!-- Sosial Media -->
      <div class="space-y-4 flex-1 flex flex-col">
        <h3 class="text-lg font-semibold">Social Media</h3>
        <ul class="space-y-2 text-[var(--color-text)] flex-grow">
          <li class="flex items-center hover:text-[var(--color-hover)] transition">
            <img src="{{ asset('images/logo_ig_compress.webp') }}" alt="Instagram" class="w-6 h-6 mr-2">
            <a href="https://www.instagram.com/stiego.id">stiego.id</a>
          </li>
          <li class="flex items-center hover:text-[var(--color-hover)] transition" style="margin-top: 10px;">
            <img src="{{ asset('images/logo_fb_compress.webp') }}" alt="Facebook" class="w-6 h-6 mr-2">
            <a href="https://www.facebook.com/stiego.id">stiego.id</a>
          </li>
          <li class="flex items-center hover:text-[var(--color-hover)] transition" style="margin-top: 10px;">
            <img src="{{ asset('images/logo_tt_compress.webp') }}" alt="TikTok" class="w-6 h-6 mr-2">
            <a href="https://www.tiktok.com/@stiego.id">stiego.id</a>
          </li>
          <li class="flex items-center hover:text-[var(--color-hover)] transition" style="margin-top: 10px;">
            <img src="{{ asset('images/logo_sp_compress.webp') }}" alt="Shopee" class="w-6 h-6 mr-2">
            <a href="https://shopee.co.id/stiego">stiego</a>
          </li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div class="space-y-4 flex-1 flex flex-col">
        <h3 class="text-lg font-semibold">Contact Us</h3>
        <ul class="space-y-2 text-[var(--color-text)] flex-grow">
          <li class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            stiegostiego@gmail.com
          </li>
          <li class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>
            +62 895 2766 8283
          </li>
          <li class="flex items-start">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Jalan Mayor Dasuki No. 57,<br>Jatibarang, Indramayu,<br>Jawa Barat, 45273
          </li>
        </ul>
      </div>
    </div>

    <div class="mt-12 pt-8 border-t border-gray-300 text-center text-gray-700">
      <p>&copy; {{ date('Y') }} Stiego. All rights reserved.</p>
    </div>
  </div>

  <!-- Tombol WhatsApp -->
  <a href="https://wa.me/6289527668283" target="_blank" class="whatsapp-float" aria-label="Chat via WhatsApp">
     <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="28" height="28" viewBox="0,0,256,256">
            <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.682,0 -23,10.318 -23,23c0,3.96 1.023,7.854 2.963,11.29l-2.926,10.44c-0.096,0.343 -0.003,0.711 0.245,0.966c0.191,0.197 0.451,0.304 0.718,0.304c0.08,0 0.161,-0.01 0.24,-0.029l10.896,-2.699c3.327,1.786 7.074,2.728 10.864,2.728c12.682,0 23,-10.318 23,-23c0,-12.682 -10.318,-23 -23,-23zM36.57,33.116c-0.492,1.362 -2.852,2.605 -3.986,2.772c-1.018,0.149 -2.306,0.213 -3.72,-0.231c-0.857,-0.27 -1.957,-0.628 -3.366,-1.229c-5.923,-2.526 -9.791,-8.415 -10.087,-8.804c-0.295,-0.389 -2.411,-3.161 -2.411,-6.03c0,-2.869 1.525,-4.28 2.067,-4.864c0.542,-0.584 1.181,-0.73 1.575,-0.73c0.394,0 0.787,0.005 1.132,0.021c0.363,0.018 0.85,-0.137 1.329,1.001c0.492,1.168 1.673,4.037 1.819,4.33c0.148,0.292 0.246,0.633 0.05,1.022c-0.196,0.389 -0.294,0.632 -0.59,0.973c-0.296,0.341 -0.62,0.76 -0.886,1.022c-0.296,0.291 -0.603,0.606 -0.259,1.19c0.344,0.584 1.529,2.493 3.285,4.039c2.255,1.986 4.158,2.602 4.748,2.894c0.59,0.292 0.935,0.243 1.279,-0.146c0.344,-0.39 1.476,-1.703 1.869,-2.286c0.393,-0.583 0.787,-0.487 1.329,-0.292c0.542,0.194 3.445,1.604 4.035,1.896c0.59,0.292 0.984,0.438 1.132,0.681c0.148,0.242 0.148,1.41 -0.344,2.771z"></path></g></g>
      </svg>
  </a>

  <!-- Tombol Back to Top -->
  <button id="backToTop" aria-label="Back to top" class="back-to-top hidden">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect x="0" y="0" width="24" height="24" rx="6" fill="#ffffff"/>
      <path d="M12 6L12 18M12 6L9 9M12 6L15 9" stroke="#B62127" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </button>

  


  <style>
    /* WhatsApp Button */
    .whatsapp-float {
      position: fixed;
      width: 50px;
      height: 50px;
      bottom: 80px;
      right: 20px;
      background-color: #25D366;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 6px rgba(0,0,0,0.3);
      z-index: 1000;
      animation: pulse 2s infinite;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .whatsapp-float:hover {
      transform: scale(1.1);
      background-color: #20ba5a;
    }
    @keyframes pulse {
      0% { box-shadow: 0 0 0 0 rgba(37,211,102,0.6); }
      70% { box-shadow: 0 0 0 12px rgba(37,211,102,0); }
      100% { box-shadow: 0 0 0 0 rgba(37,211,102,0); }
    }

    /* Back to Top Button */
    .back-to-top {
      position: fixed;
      bottom: 20px; 
      right: 20px;
      background-color: #fff;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 6px rgba(0,0,0,0.3);
      cursor: pointer;
      transition: all 0.3s ease;
      z-index: 999;
    }
    .back-to-top:hover {
      transform: scale(1.1);
      box-shadow: 0 6px 12px rgba(0,0,0,0.3);
    }
    .back-to-top.hidden {
      display: none;
    }
  </style>

  <script>
    // tombol back to top
    const backToTop = document.getElementById("backToTop");

    window.addEventListener("scroll", () => {
      if (window.scrollY > 400) {
        backToTop.classList.remove("hidden");
      } else {
        backToTop.classList.add("hidden");
      }
    });

    backToTop.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  </script>
</footer>
