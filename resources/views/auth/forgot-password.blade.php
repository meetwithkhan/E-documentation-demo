<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password — {{ config('brand.name') }}</title>
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

  <!-- Dark toggle -->
  <div class="fixed top-4 right-4">
    <button @click="toggleDark()"
            class="w-9 h-9 rounded-lg flex items-center justify-center transition-colors
                   bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-700
                   text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
      <svg x-show="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343
                 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707
                 M12 8a4 4 0 100 8 4 4 0 000-8z"/>
      </svg>
      <svg x-show="!isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003
                 9.003 0 008.354-5.646z"/>
      </svg>
    </button>
  </div>

<div class="w-full max-w-sm">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-8 shadow-sm">

    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <x-brand-logo size="lg"/>
    </div>

    <!-- Icon -->
    <div class="w-14 h-14 rounded-full bg-amber-50 dark:bg-amber-900/20 flex items-center
                justify-center mx-auto mb-4">
      <svg class="w-7 h-7 text-amber-500 dark:text-amber-400"
           fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1
                 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
      </svg>
    </div>

    <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">
      Forgot your password?
    </h2>
    <p class="text-center text-xs text-gray-500 dark:text-gray-400 mb-6 leading-relaxed">
      No worries. Enter your email and we'll send you a reset link.
    </p>

    <!-- Status Message -->
    @if (session('status'))
      <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200
                  dark:border-emerald-800 rounded-lg px-4 py-3 mb-5">
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-emerald-500 flex-shrink-0"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7"/>
          </svg>
          <p class="text-xs text-emerald-700 dark:text-emerald-400">
            {{ session('status') }}
          </p>
        </div>
      </div>
    @endif

    <!-- Error -->
    @if ($errors->any())
      <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200
                  dark:border-rose-800 rounded-lg px-4 py-3 mb-4">
        <p class="text-xs text-rose-600 dark:text-rose-400">{{ $errors->first() }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
      @csrf

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Email Address
        </label>
        <input type="email" name="email" value="{{ old('email') }}"
               required autofocus
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 placeholder-gray-400
                      dark:placeholder-gray-700 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="your@email.com"/>
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                     font-medium py-2.5 rounded-lg transition-colors">
        Send Reset Link
      </button>
    </form>

    <!-- Back to login -->
    <div class="mt-5 text-center">
      <a href="{{ route('login') }}"
         class="inline-flex items-center gap-1.5 text-xs text-gray-500
                dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400
                transition-colors">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Sign In
      </a>
    </div>

  </div>
</div>

</body>
</html>