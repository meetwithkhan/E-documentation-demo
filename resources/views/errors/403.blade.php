<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>403 — Access Denied | {{ config('brand.name') }}</title>
  <script>
    (function() {
      const t = localStorage.getItem('theme');
      if (t === 'dark' || t === null) document.documentElement.classList.add('dark');
    })();
  </script>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 dark:bg-gray-950 transition-colors duration-200">

<div class="min-h-full flex flex-col items-center justify-center p-6">

  <div class="w-full max-w-md bg-white dark:bg-gray-900 border border-gray-200
              dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden text-center">

    <!-- Top bar -->
    <div class="h-1 bg-gradient-to-r from-rose-500 to-orange-500"></div>

    <div class="p-10">

      <!-- Number -->
      <div class="relative mb-6">
        <p class="text-9xl font-black text-gray-100 dark:text-gray-800 select-none
                  leading-none">
          403
        </p>
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="w-16 h-16 rounded-full bg-rose-50 dark:bg-rose-900/20
                      flex items-center justify-center">
            <svg class="w-8 h-8 text-rose-500 dark:text-rose-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0
                       00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
          </div>
        </div>
      </div>

      <!-- Brand -->
      <div class="flex justify-center mb-6">
        <x-brand-logo size="md"/>
      </div>

      <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
        Access Denied
      </h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 leading-relaxed">
        You don't have permission to view this page.
        If you think this is a mistake, contact your administrator.
      </p>

      <!-- Error message from exception if any -->
      @if(isset($exception) && $exception->getMessage())
        <div class="bg-rose-50 dark:bg-rose-900/10 border border-rose-200
                    dark:border-rose-800 rounded-lg px-4 py-2.5 mb-6 text-left">
          <p class="text-xs text-rose-600 dark:text-rose-400">
            {{ $exception->getMessage() }}
          </p>
        </div>
      @else
        <div class="mb-6"></div>
      @endif

      <!-- Role info -->
      @auth
        <div class="bg-gray-50 dark:bg-gray-950 border border-gray-200
                    dark:border-gray-800 rounded-lg px-4 py-3 mb-6 text-left">
          <p class="text-xs text-gray-500 dark:text-gray-500 mb-1">Logged in as</p>
          <div class="flex items-center gap-2">
            <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center
                        justify-center text-xs font-bold text-white">
              {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div>
              <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
                {{ auth()->user()->name }}
              </p>
              <p class="text-xs text-gray-400 dark:text-gray-600">
                {{ auth()->user()->employee_id ? 'Employee ID: ' . auth()->user()->employee_id : 'No Employee ID' }}
              </p>
            </div>
          </div>
        </div>
      @endauth

      <!-- Actions -->
      <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
        @auth
          <a href="{{ route('dashboard') }}"
             class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                    bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                    px-6 py-2.5 rounded-lg transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1
                       0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1
                       0 001 1m-6 0h6"/>
            </svg>
            Go to Dashboard
          </a>
        @else
          <a href="{{ route('login') }}"
             class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                    bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                    px-6 py-2.5 rounded-lg transition-colors">
            Go to Login
          </a>
        @endauth

        <button onclick="history.back()"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                       bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700
                       text-gray-700 dark:text-gray-300 text-sm font-medium px-6 py-2.5
                       rounded-lg border border-gray-200 dark:border-gray-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
          </svg>
          Go Back
        </button>
      </div>

    </div>
  </div>

  <p class="text-xs text-gray-400 dark:text-gray-600 mt-6">
    {{ config('brand.name') }} · {{ config('brand.location') }}
  </p>

</div>
</body>
</html>