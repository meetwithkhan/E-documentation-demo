@if (session('success'))
<div class="mb-4 bg-emerald-900/30 border border-emerald-800 rounded-lg px-4 py-3 flex items-center gap-2">
  <svg class="w-4 h-4 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
  </svg>
  <p class="text-sm text-emerald-400">{{ session('success') }}</p>
</div>
@endif

@if (session('error'))
<div class="mb-4 bg-rose-900/30 border border-rose-800 rounded-lg px-4 py-3 flex items-center gap-2">
  <svg class="w-4 h-4 text-rose-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
  </svg>
  <p class="text-sm text-rose-400">{{ session('error') }}</p>
</div>
@endif