<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>500 — Server Error | {{ config('brand.name') }}</title>
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

    <div class="h-1 bg-gradient-to-r from-amber-500 to-rose-500"></div>

    <div class="p-10">

      <div class="relative mb-6">
        <p class="text-9xl font-black text-gray-100 dark:text-gray-800 select-none leading-none">
          500
        </p>
        <div class="absolute inset-0 flex items-center justify-center">
          <div class="w-16 h-16 rounded-full bg-amber-50 dark:bg-amber-900/20
                      flex items-center justify-center">
            <svg class="w-8 h-8 text-amber-500 dark:text-amber-400"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667
                       1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464
                       0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
          </div>
        </div>
      </div>

      <div class="flex justify-center mb-6">
        <x-brand-logo size="md"/>
      </div>

      <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
        Server Error
      </h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">
        Something went wrong on our end. We're working to fix it.
        Please try again in a few moments.
      </p>

      <div class="inline-flex items-center gap-2 bg-amber-50 dark:bg-amber-900/20
                  border border-amber-200 dark:border-amber-800 rounded-lg
                  px-4 py-2.5 mb-8">
        <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
        <span class="text-xs text-amber-700 dark:text-amber-400 font-medium">
          System experiencing issues
        </span>
      </div>

      <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
        <button onclick="location.reload()"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                       bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                       px-6 py-2.5 rounded-lg transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11
                     11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
          </svg>
          Try Again
        </button>

        @auth
          <a href="{{ route('dashboard') }}"
             class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                    bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700
                    text-gray-700 dark:text-gray-300 text-sm font-medium px-6 py-2.5
                    rounded-lg border border-gray-200 dark:border-gray-700 transition-colors">
            Go to Dashboard
          </a>
        @else
          <a href="{{ route('login') }}"
             class="w-full sm:w-auto inline-flex items-center justify-center gap-2
                    bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700
                    text-gray-700 dark:text-gray-300 text-sm font-medium px-6 py-2.5
                    rounded-lg border border-gray-200 dark:border-gray-700 transition-colors">
            Go to Login
          </a>
        @endauth
      </div>

    </div>
  </div>

  <p class="text-xs text-gray-400 dark:text-gray-600 mt-6">
    {{ config('brand.name') }} · {{ config('brand.location') }}
  </p>

</div>
</body>
</html>