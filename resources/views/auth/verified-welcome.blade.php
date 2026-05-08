<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Email Verified — {{ config('brand.name') }}</title>
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
             bg-gray-50 dark:bg-gray-950 transition-colors duration-200">

<div class="w-full max-w-md" x-data="welcomeTimer()">

  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl shadow-sm overflow-hidden">

    <!-- Top color bar -->
    <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500"></div>

    <div class="p-8 text-center">

      <!-- Animated checkmark -->
      <div class="relative w-20 h-20 mx-auto mb-6">
        <div class="w-20 h-20 rounded-full bg-emerald-50 dark:bg-emerald-900/20
                    flex items-center justify-center">
          <svg class="w-10 h-10 text-emerald-500" fill="none"
               stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                  d="M5 13l4 4L19 7"/>
          </svg>
        </div>
        <span class="absolute inset-0 rounded-full border-2 border-emerald-400
                     dark:border-emerald-600 animate-ping opacity-20"></span>
      </div>

      <!-- Brand -->
      <div class="flex justify-center mb-5">
        <x-brand-logo size="md"/>
      </div>

      <h1 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-1">
        Email Verified!
      </h1>
      <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
        Welcome to <strong class="text-gray-700 dark:text-gray-300">
          {{ config('brand.name') }}
        </strong>. Your account is now active.
      </p>

      <!-- User Info Card -->
      <div class="bg-gray-50 dark:bg-gray-950 border border-gray-200
                  dark:border-gray-800 rounded-xl p-4 mb-6 text-left">
        <div class="flex items-center gap-3 mb-3">
          <div class="w-10 h-10 rounded-full bg-indigo-600 flex items-center
                      justify-center text-sm font-bold text-white flex-shrink-0">
            {{ strtoupper(substr($user->name, 0, 2)) }}
          </div>
          <div class="min-w-0">
            <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">
              {{ $user->name }}
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-600 truncate">
              {{ $user->email }}
            </p>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          @if($user->employee_id)
          <div class="bg-white dark:bg-gray-900 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2">
            <p class="text-xs text-gray-400 dark:text-gray-600 mb-0.5">Employee ID</p>
            <p class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400">
              {{ $user->employee_id }}
            </p>
          </div>
          @endif
          @if($user->designation)
          <div class="bg-white dark:bg-gray-900 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2">
            <p class="text-xs text-gray-400 dark:text-gray-600 mb-0.5">Designation</p>
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
              {{ $user->designation->name }}
            </p>
          </div>
          @endif
          @if($user->department)
          <div class="bg-white dark:bg-gray-900 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2">
            <p class="text-xs text-gray-400 dark:text-gray-600 mb-0.5">Department</p>
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
              {{ $user->department->name }}
            </p>
          </div>
          @endif
          @if($user->function)
          <div class="bg-white dark:bg-gray-900 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2">
            <p class="text-xs text-gray-400 dark:text-gray-600 mb-0.5">Function</p>
            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
              {{ $user->function->name }}
            </p>
          </div>
          @endif
        </div>
      </div>

      <!-- Progress bar countdown -->
      <div class="mb-5">
        <div class="flex items-center justify-between mb-2">
          <span class="text-xs text-gray-400 dark:text-gray-600">
            Redirecting to dashboard...
          </span>
          <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400"
                x-text="countdown + 's'">
          </span>
        </div>
        <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
          <div class="h-full rounded-full bg-indigo-600 dark:bg-indigo-500
                      transition-all duration-1000 ease-linear"
               :style="'width: ' + progress + '%'">
          </div>
        </div>
      </div>

      <!-- CTA -->
      <a href="{{ route('dashboard') }}"
         class="w-full inline-flex items-center justify-center gap-2
                bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                font-medium py-2.5 rounded-lg transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1
                   0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1
                   0 001 1m-6 0h6"/>
        </svg>
        Go to Dashboard Now
      </a>

    </div>
  </div>

</div>

@push('scripts')
<script>
function welcomeTimer() {
  return {
    countdown: 5,
    progress: 0,

    init() {
      setTimeout(() => { this.progress = 100; }, 100);

      const interval = setInterval(() => {
        this.countdown--;
        if (this.countdown <= 0) {
          clearInterval(interval);
          window.location.href = '{{ route('dashboard') }}';
        }
      }, 1000);
    }
  }
}
</script>
@endpush

</body>
</html>