import collapse from '@alpinejs/collapse';
import intersect from '@alpinejs/intersect';
import { initScrollAnimations } from './scroll-animations';

// PENTING: gunakan Alpine milik Livewire (diset otomatis oleh @livewireScripts),
// JANGAN import 'alpinejs' sendiri. Meng-import dua kali akan memicu
// "Detected multiple instances of Alpine running" yang merusak sinkronisasi
// wire:model (x-model) milik Livewire.
const Alpine = window.Alpine;

if (Alpine) {
  Alpine.plugin(collapse);
  Alpine.plugin(intersect);
}

// Inisialisasi animasi scroll setelah DOM siap
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initScrollAnimations);
} else {
  initScrollAnimations();
}
