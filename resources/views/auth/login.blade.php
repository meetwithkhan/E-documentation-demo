<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign In — {{ \App\Helpers\Brand::name() }}</title>

  {{-- Prevent dark mode flash --}}
  <script>
    (function() {
      const theme = localStorage.getItem('theme');
      if (theme === 'dark' || theme === null) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    })();
  </script>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center p-4
             bg-gray-50 dark:bg-gray-950 transition-colors duration-200"
      x-data="{
        isDark: document.documentElement.classList.contains('dark'),
        toggleDark() {
          this.isDark = !this.isDark;
          if (this.isDark) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
          } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
          }
        }
      }">



<div class="w-full max-w-sm">
    <!-- Dark mode toggle top right -->
  <div class="fixed top-4 right-4 z-50">
    <button @click="toggleDark()"
            class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                   bg-gray-100 dark:bg-gray-800
                   border border-gray-200 dark:border-gray-700
                   text-gray-500 dark:text-gray-400
                   hover:text-gray-900 dark:hover:text-white">
      <!-- Sun -->
      <svg x-show="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707
                 M6.343 17.657l-.707.707M17.657 17.657l-.707-.707
                 M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
      </svg>
      <!-- Moon -->
      <svg x-show="!isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003
                 9.003 0 008.354-5.646z"/>
      </svg>
    </button>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-8 shadow-sm">

    <!-- Logo -->
    <div class="flex items-center gap-2 mb-6">
      <x-brand-logo size="lg" />
    </div>

    <h2 class="text-gray-800 dark:text-gray-100 text-xl font-medium mb-1">
      Welcome back
    </h2>
    <p class="text-gray-400 dark:text-gray-500 text-sm mb-6">
      Sign in to your dashboard
    </p>

    @if (session('status'))
      <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200
                  dark:border-emerald-800 rounded-lg p-3 mb-4">
        <p class="text-emerald-700 dark:text-emerald-400 text-sm">{{ session('status') }}</p>
      </div>
    @endif

    @if ($errors->any())
      <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200
                  dark:border-rose-800 rounded-lg p-3 mb-4">
        <p class="text-rose-600 dark:text-rose-400 text-sm">{{ $errors->first() }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Email address
        </label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 placeholder-gray-400
                      dark:placeholder-gray-700 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="admin@example.com"/>
      </div>

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Password
        </label>
        <input type="password" name="password" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 placeholder-gray-400
                      dark:placeholder-gray-700 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="••••••••"/>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer">
          <input type="checkbox" name="remember"
                 class="rounded border-gray-300 dark:border-gray-700
                        bg-gray-50 dark:bg-gray-950 text-indigo-600
                        focus:ring-indigo-500"/>
          Remember me
        </label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}"
             class="text-xs text-indigo-500 hover:text-indigo-400 transition-colors">
            Forgot password?
          </a>
        @endif
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                     font-medium py-2.5 rounded-lg transition-colors mt-2">
        Sign in
      </button>
    </form>

  </div>
</div>

</body>
</html>