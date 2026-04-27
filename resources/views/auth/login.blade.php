<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign In — {{ \App\Helpers\Brand::name() }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex items-center justify-center p-4 bg-gray-950">

<div class="w-full max-w-sm">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-8">

    <!-- Logo -->
     <x-brand-logo size="lg" />
    <!-- <div class="flex items-center gap-2 mb-6">
      <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
        <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
          <path d="M13 3L4 14h7l-2 7 9-11h-7l2-7z"/>
        </svg>
      </div>
      <span class="text-white font-medium">AdminBase</span>
    </div> -->

    <h2 class="text-gray-100 text-xl font-medium mb-1">Welcome back</h2>
    <p class="text-gray-500 text-sm mb-6">Sign in to your dashboard</p>

    <!-- Session Status -->
    @if (session('status'))
      <div class="bg-green-900/30 border border-green-800 rounded-lg p-3 mb-4">
        <p class="text-green-400 text-sm">{{ session('status') }}</p>
      </div>
    @endif

    <!-- Errors -->
    @if ($errors->any())
      <div class="bg-red-900/30 border border-red-800 rounded-lg p-3 mb-4">
        <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf

      <!-- Email -->
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Email address</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 placeholder-gray-700
                      focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="admin@example.com"/>
      </div>

      <!-- Password -->
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Password</label>
        <input type="password" name="password" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 placeholder-gray-700
                      focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="••••••••"/>
      </div>

      <!-- Remember + Forgot -->
      <div class="flex items-center justify-between">
        <label class="flex items-center gap-2 text-xs text-gray-500 cursor-pointer">
          <input type="checkbox" name="remember"
                 class="rounded border-gray-700 bg-gray-950 text-indigo-600 focus:ring-indigo-500"/>
          Remember me
        </label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-xs text-indigo-400 hover:text-indigo-300">
            Forgot password?
          </a>
        @endif
      </div>

      <!-- Submit -->
      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                     py-2.5 rounded-lg transition-colors mt-2">
        Sign in
      </button>
    </form>
  </div>
</div>

</body>
</html>