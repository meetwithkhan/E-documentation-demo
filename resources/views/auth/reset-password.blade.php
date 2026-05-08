<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password — {{ config('brand.name') }}</title>
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
        show: false,
        showConfirm: false,
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
    <div class="w-14 h-14 rounded-full bg-indigo-50 dark:bg-indigo-900/20
                flex items-center justify-center mx-auto mb-4">
      <svg class="w-7 h-7 text-indigo-500 dark:text-indigo-400"
           fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2
                 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
      </svg>
    </div>

    <h2 class="text-center text-lg font-semibold text-gray-900 dark:text-gray-100 mb-1">
      Set new password
    </h2>
    <p class="text-center text-xs text-gray-500 dark:text-gray-400 mb-6">
      This link can only be used once. Create a strong password.
    </p>

    <!-- Errors -->
    @if ($errors->any())
      <div class="bg-rose-50 dark:bg-rose-900/20 border border-rose-200
                  dark:border-rose-800 rounded-lg px-4 py-3 mb-4">
        <p class="text-xs text-rose-600 dark:text-rose-400">{{ $errors->first() }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
      @csrf

      <input type="hidden" name="token" value="{{ $request->route('token') }}"/>

      <!-- Email -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Email Address
        </label>
        <input type="email" name="email"
               value="{{ old('email', $request->email) }}"
               required autofocus
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('email')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- New Password -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          New Password
        </label>
        <div class="relative">
          <input :type="show ? 'text' : 'password'"
                 name="password"
                 required
                 class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                        dark:border-gray-800 rounded-lg px-3 py-2.5 pr-10 text-sm
                        text-gray-900 dark:text-gray-200 focus:outline-none
                        focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                 placeholder="Min. 8 characters"/>
          <button type="button" @click="show = !show"
                  class="absolute right-3 top-1/2 -translate-y-1/2
                         text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z
                       M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                       9.542 7-1.274 4.057-5.064 7-9.542 7-4.477
                       0-8.268-2.943-9.542-7z"/>
            </svg>
            <svg x-show="show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97
                       9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242
                       4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0
                       0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025
                       10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
          </button>
        </div>
        @error('password')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Confirm Password
        </label>
        <div class="relative">
          <input :type="showConfirm ? 'text' : 'password'"
                 name="password_confirmation"
                 required
                 class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                        dark:border-gray-800 rounded-lg px-3 py-2.5 pr-10 text-sm
                        text-gray-900 dark:text-gray-200 focus:outline-none
                        focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                 placeholder="Repeat password"/>
          <button type="button" @click="showConfirm = !showConfirm"
                  class="absolute right-3 top-1/2 -translate-y-1/2
                         text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z
                       M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                       9.542 7-1.274 4.057-5.064 7-9.542 7-4.477
                       0-8.268-2.943-9.542-7z"/>
            </svg>
            <svg x-show="showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97
                       9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242
                       4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0
                       0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025
                       10.025 0 01-4.132 5.411m0 0L21 21"/>
            </svg>
          </button>
        </div>
      </div>

      <!-- Password strength -->
      <div x-data="passwordStrength()" class="space-y-1.5">
        <div class="flex gap-1">
          <div class="h-1 flex-1 rounded-full transition-colors duration-300"
               :class="strength >= 1 ? strengthColor : 'bg-gray-200 dark:bg-gray-700'"></div>
          <div class="h-1 flex-1 rounded-full transition-colors duration-300"
               :class="strength >= 2 ? strengthColor : 'bg-gray-200 dark:bg-gray-700'"></div>
          <div class="h-1 flex-1 rounded-full transition-colors duration-300"
               :class="strength >= 3 ? strengthColor : 'bg-gray-200 dark:bg-gray-700'"></div>
          <div class="h-1 flex-1 rounded-full transition-colors duration-300"
               :class="strength >= 4 ? strengthColor : 'bg-gray-200 dark:bg-gray-700'"></div>
        </div>
        <p class="text-xs transition-colors" :class="strengthTextColor" x-text="strengthLabel"></p>
      </div>

      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                     font-medium py-2.5 rounded-lg transition-colors mt-2">
        Reset Password
      </button>
    </form>

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

  <!-- One-time notice -->
  <p class="text-center text-xs text-gray-400 dark:text-gray-600 mt-4">
    🔒 This reset link expires after one use or 60 minutes.
  </p>
</div>

@push('scripts')
<script>
function passwordStrength() {
  return {
    strength: 0,
    strengthLabel: '',
    strengthColor: 'bg-gray-300',
    strengthTextColor: 'text-gray-400',

    init() {
      const input = document.querySelector('input[name="password"]');
      if (input) {
        input.addEventListener('input', () => this.check(input.value));
      }
    },

    check(val) {
      let s = 0;
      if (val.length >= 8)                   s++;
      if (/[A-Z]/.test(val))                 s++;
      if (/[0-9]/.test(val))                 s++;
      if (/[^A-Za-z0-9]/.test(val))          s++;

      this.strength = s;

      const map = {
        0: ['', 'bg-gray-300', 'text-gray-400'],
        1: ['Weak', 'bg-rose-500', 'text-rose-500'],
        2: ['Fair', 'bg-amber-500', 'text-amber-500'],
        3: ['Good', 'bg-blue-500', 'text-blue-500'],
        4: ['Strong', 'bg-emerald-500', 'text-emerald-500'],
      };

      this.strengthLabel     = map[s][0];
      this.strengthColor     = map[s][1];
      this.strengthTextColor = map[s][2];
    }
  }
}
</script>
@endpush

</body>
</html>