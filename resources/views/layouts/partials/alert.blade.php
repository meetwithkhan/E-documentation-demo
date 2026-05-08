@if (session('success'))
<div class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg
            bg-emerald-50 dark:bg-emerald-900/20
            border border-emerald-200 dark:border-emerald-800">
  <svg class="w-4 h-4 flex-shrink-0 text-emerald-500 dark:text-emerald-400"
       fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M5 13l4 4L19 7"/>
  </svg>
  <p class="text-sm text-emerald-700 dark:text-emerald-400">
    {{ session('success') }}
  </p>
</div>
@endif

@if (session('error'))
<div class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg
            bg-rose-50 dark:bg-rose-900/20
            border border-rose-200 dark:border-rose-800">
  <svg class="w-4 h-4 flex-shrink-0 text-rose-500 dark:text-rose-400"
       fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M6 18L18 6M6 6l12 12"/>
  </svg>
  <p class="text-sm text-rose-700 dark:text-rose-400">
    {{ session('error') }}
  </p>
</div>
@endif

@if (session('warning'))
<div class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg
            bg-amber-50 dark:bg-amber-900/20
            border border-amber-200 dark:border-amber-800">
  <svg class="w-4 h-4 flex-shrink-0 text-amber-500 dark:text-amber-400"
       fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0
             000-3L12.71 3.86a2 2 0 00-3.42 0z"/>
  </svg>
  <p class="text-sm text-amber-700 dark:text-amber-400">
    {{ session('warning') }}
  </p>
</div>
@endif

@if (session('info'))
<div class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg
            bg-blue-50 dark:bg-blue-900/20
            border border-blue-200 dark:border-blue-800">
  <svg class="w-4 h-4 flex-shrink-0 text-blue-500 dark:text-blue-400"
       fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
  </svg>
  <p class="text-sm text-blue-700 dark:text-blue-400">
    {{ session('info') }}
  </p>
</div>
@endif

@if ($errors->any())
<div class="mb-4 flex items-start gap-2 px-4 py-3 rounded-lg
            bg-rose-50 dark:bg-rose-900/20
            border border-rose-200 dark:border-rose-800">
  <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-rose-500 dark:text-rose-400"
       fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M6 18L18 6M6 6l12 12"/>
  </svg>
  <ul class="text-sm text-rose-700 dark:text-rose-400 space-y-0.5">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif