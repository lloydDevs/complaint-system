  {{-- ========== FOOTER ========== --}}
  <style>
      .nav-link {
          position: relative;
      }

      .nav-link::after {
          content: "";
          position: absolute;
          left: 0;
          right: 0;
          bottom: -6px;
          height: 2px;
          background: var(--da-green);
          transform: scaleX(0);
          transform-origin: right center;
          transition: transform .35s ease;
      }

      .nav-link:hover::after,
      .nav-link.active::after {
          transform: scaleX(1);
          transform-origin: left center;
      }
  </style>
  <footer class="bg-gradient-to-br from-da-green-dark to-da-green text-white/90">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid lg:grid-cols-3 gap-10">
          <div>
              <div class="flex items-center gap-3 mb-4">
                  <div class="w-12 h-12 rounded-full bg-white/15 flex items-center justify-center font-extrabold">
                      <img src="{{ asset('logo/damimaropa-logo.jpg') }}" alt="">
                  </div>
                  <div>
                      <p class="font-extrabold text-white">Department of Agriculture MIMAROPA</p>
                      <p class="text-xs text-white/70">Republic of the Philippines</p>
                  </div>
              </div>
              <p class="text-sm">3F ATI Building, Elliptical Rd, Diliman, QC | King's Building, Camilmil, Calapan
                  City,
                  Oriental Mindoro1</p>
              <p class="text-sm">Philippines</p>
              <p class="text-sm mt-3"><i data-lucide="phone" class="w-4 h-4 inline mr-1"></i> 09477115706</p>
              <p class="text-sm"><i data-lucide="mail" class="w-4 h-4 inline mr-1"></i> ored@mimaropa.da.gov.phh
              </p>
          </div>

          <div>
              <p class="font-bold text-white mb-3 tracking-wide">Quick Links</p>
              <ul class="space-y-2 text-sm">
                  @php
                      $links = [
                          ['Home', '/'],
                          ['Submit a Complaint', '/newcomplaint'],
                          ['Track My Complaint', '/trackrecord'],
                          ['About DA-CARE', '/about'],
                      ];
                  @endphp
                  @foreach ($links as [$label, $href])
                      @php $active = request()->is(trim($href, '/') ?: '/'); @endphp
                      <a href="{{ url($href) }}"
                          class="nav-link hover:text-da-green transition {{ $active ? 'text-da-green font-semibold active' : '' }}">
                          {{ $label }}
                      </a>
                  @endforeach
              </ul>
          </div>

          <div>
              <p class="font-bold text-white mb-3 tracking-wide">Connect</p>
              <div class="flex gap-3">
                  @foreach ([['facebook', 'https://facebook.com'], ['mail', 'mailto:dacare@da.gov.ph']] as [$icon, $href])
                      <a href="{{ $href }}"
                          class="w-10 h-10 rounded-full bg-white/10 hover:bg-emerald-500 hover:text-emerald-900 flex items-center justify-center transition group">
                          <!-- Added a class for targeting if needed, and ensured data-lucide is correct -->
                          <i data-lucide="{{ $icon }}" class="w-5 h-5 text-white group-hover:text-inherit"></i>
                      </a>
                  @endforeach
              </div>
              <p class="text-xs text-white/70 mt-5 leading-relaxed">
                  DA-CARE is committed to transparency, accountability, and citizen-centered service.
              </p>
          </div>
      </div>
      <div class="border-t border-white/10">
          <div
              class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/70">
              <p>© {{ date('Y') }} Department of Agriculture MIMAROPA | Powered by MIS | All rights reserved.</p>

          </div>
      </div>
  </footer>
  <script>
      // This function tells Lucide to replace all <i data-lucide="..."> with actual SVGs
      document.addEventListener('DOMContentLoaded', () => {
          if (typeof lucide !== 'undefined') {
              lucide.createIcons();
          }
      });
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
      tailwind.config = {
          theme: {
              extend: {
                  colors: {
                      'da-green': '#1f6b3a',
                      'da-green-dark': '#16532c',
                      'da-gold': '#d4a437',
                      'da-cream': '#fdf6e3',
                      'da-soft-green': '#e8f3ec',
                      'da-soft-blue': '#e8eef7',
                      'da-soft-amber': '#fbf2dc',
                  },
                  fontFamily: {
                      sans: ['Inter', 'system-ui', 'sans-serif'],
                  },
              },
          },
      };
  </script>
