<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verify Email — {{ config('brand.name') }}</title>
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

<div class="w-full max-w-md">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-8 shadow-sm">

    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <x-brand-logo size="lg"/>
    </div>

    @if (session('status') == 'verification-link-sent')
    <!-- Success state -->
    <div class="text-center">
      <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-emerald-900/20
                  flex items-center justify-center mx-auto mb-4">
        <svg class="w-8 h-8 text-emerald-500 dark:text-emerald-400"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7"/>
        </svg>
      </div>
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Email sent!
      </h2>
      <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        A new verification link has been sent to
        <span class="font-medium text-indigo-600 dark:text-indigo-400">
          {{ auth()->user()->email }}
        </span>
      </p>
      <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200
                  dark:border-emerald-800 rounded-lg px-4 py-3 text-left mb-6">
        <p class="text-xs text-emerald-700 dark:text-emerald-400 leading-relaxed">
          ✓ Check your inbox and click the verification link.
          Don't forget to check your spam folder if you don't see it.
        </p>
      </div>
    </div>
    @else
    <!-- Default state -->
    <div class="text-center">
      <div class="w-16 h-16 rounded-full bg-indigo-50 dark:bg-indigo-900/20
                  flex items-center justify-center mx-auto mb-4"
           x-data="{ bounce: false }"
           x-init="setInterval(() => { bounce = true; setTimeout(() => bounce = false, 600) }, 3000)"
           :class="bounce ? 'scale-110' : 'scale-100'"
           style="transition: transform 0.3s ease;">
        <svg class="w-8 h-8 text-indigo-500 dark:text-indigo-400"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0
                   00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
      </div>

      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
        Verify your email address
      </h2>
      <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
        We sent a verification link to
      </p>
      <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 mb-6">
        {{ auth()->user()->email }}
      </p>
    </div>

    <!-- User info -->
    <div class="bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800
                rounded-lg p-4 mb-6">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center
                    text-sm font-semibold text-white flex-shrink-0">
          {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
        </div>
        <div class="min-w-0">
          <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">
            {{ auth()->user()->name }}
          </p>
          <p class="text-xs text-gray-400 dark:text-gray-600 truncate">
            {{ auth()->user()->employee_id ?? '' }}
            @if(auth()->user()->designation)
              · {{ auth()->user()->designation->name }}
            @endif
          </p>
        </div>
      </div>
    </div>

    <!-- Steps -->
    <div class="space-y-2 mb-6">
      <div class="flex items-center gap-3">
        <div class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center
                    justify-center flex-shrink-0">
          <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400">Account created</p>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-6 h-6 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center
                    justify-center flex-shrink-0">
          <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
        </div>
        <p class="text-xs text-gray-700 dark:text-gray-300 font-medium">
          Verify your email
        </p>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-6 h-6 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center
                    justify-center flex-shrink-0">
          <span class="text-xs text-gray-400 dark:text-gray-600 font-bold">3</span>
        </div>
        <p class="text-xs text-gray-400 dark:text-gray-600">Access your dashboard</p>
      </div>
    </div>
    @endif

    <!-- Resend -->
    <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
      @csrf
      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                     font-medium py-2.5 rounded-lg transition-colors">
        {{ session('status') == 'verification-link-sent' ? 'Resend Again' : 'Resend Verification Email' }}
      </button>
    </form>

    <!-- Sign out -->
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
              class="w-full text-xs text-gray-400 dark:text-gray-600
                     hover:text-gray-600 dark:hover:text-gray-400
                     transition-colors py-1">
        Sign out and use a different account
      </button>
    </form>

  </div>
</div>

</body>
</html>