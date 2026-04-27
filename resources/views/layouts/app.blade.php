<!DOCTYPE html>
<html lang="en" class="h-full" x-data="darkMode()" :class="{ 'dark': isDark }">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Dashboard') — {{ \App\Helpers\Brand::name() }}</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-950 font-sans" x-data="{ sidebarOpen: false }">

  <!-- Mobile overlay -->
  <div x-show="sidebarOpen"
       x-transition:enter="transition-opacity ease-linear duration-200"
       x-transition:enter-start="opacity-0"
       x-transition:enter-end="opacity-100"
       x-transition:leave="transition-opacity ease-linear duration-200"
       x-transition:leave-start="opacity-100"
       x-transition:leave-end="opacity-0"
       @click="sidebarOpen = false"
       class="fixed inset-0 z-20 bg-black/60 lg:hidden"></div>

  <div class="flex h-full">

    <!-- ========== SIDEBAR ========== -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="fixed inset-y-0 left-0 z-30 w-56 bg-gray-900 border-r border-gray-800
                  flex flex-col transition-transform duration-200 ease-in-out
                  lg:translate-x-0 lg:static lg:flex-shrink-0">

      <!-- Logo -->
       <x-brand-logo size="md" />
      <!-- <div class="flex items-center gap-2.5 px-4 h-14 border-b border-gray-800 flex-shrink-0">
        <div class="w-7 h-7 bg-indigo-600 rounded-lg flex items-center justify-center flex-shrink-0">
          <svg class="w-4 h-4 fill-white" viewBox="0 0 24 24">
            <path d="M13 3L4 14h7l-2 7 9-11h-7l2-7z"/>
          </svg>
        </div>
        <span class="text-white font-medium text-sm">AdminBase</span>
      </div> -->


      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto p-3 space-y-5">

        <div>
          <p class="text-xs text-gray-600 uppercase tracking-widest px-2 mb-1.5">Main</p>
          <div class="space-y-0.5">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800/60 hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-indigo-500 flex-shrink-0"></span>
              Dashboard
            </a>
            <a href="#"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('analytics*') ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800/60 hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-teal-500 flex-shrink-0"></span>
              Analytics
            </a>
            <a href="#"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('reports*') ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800/60 hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-blue-500 flex-shrink-0"></span>
              Reports
            </a>
          </div>
        </div>

        @if(auth()->user()->hasAnyRole(['admin', 'manager']))
<div>
  <p class="text-xs text-gray-600 uppercase tracking-widest px-2 mb-1.5">Manage</p>
  <div class="space-y-0.5">
    <a href="{{ route('users.index') }}"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
              {{ request()->routeIs('users*') ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800/60 hover:text-gray-300' }}">
      <span class="w-2 h-2 rounded-sm bg-amber-500 flex-shrink-0"></span>
      Users
    </a>
    <a href="{{ route('roles.index') }}"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
              {{ request()->routeIs('roles*') ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800/60 hover:text-gray-300' }}">
      <span class="w-2 h-2 rounded-sm bg-rose-500 flex-shrink-0"></span>
      Roles
    </a>
    <a href="#"
       class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
              {{ request()->routeIs('settings*') ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800/60 hover:text-gray-300' }}">
      <span class="w-2 h-2 rounded-sm bg-gray-500 flex-shrink-0"></span>
      Settings
    </a>
  </div>
</div>
@endif

      </nav>

      <!-- User Profile at Bottom -->
      <div class="flex-shrink-0 border-t border-gray-800 p-3">
  <div class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg">
    <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center
                text-xs font-medium text-white flex-shrink-0">
      {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
    </div>
    <a href="{{ route('profile.edit') }}" class="flex-1 min-w-0 hover:opacity-80 transition-opacity">
      <p class="text-xs text-gray-300 truncate font-medium">{{ auth()->user()->name }}</p>
      <p class="text-xs text-gray-600 truncate">{{ auth()->user()->email }}</p>
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="text-gray-600 hover:text-gray-300 transition-colors" title="Logout">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
      </button>
    </form>
  </div>
</div>

    </aside>
    <!-- ========== END SIDEBAR ========== -->

    <!-- ========== MAIN AREA ========== -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

      <!-- Top Bar -->
      <header class="flex-shrink-0 h-14 bg-gray-900 border-b border-gray-800
                     flex items-center gap-4 px-4">

        <!-- Hamburger (mobile only) -->
        <button @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden text-gray-400 hover:text-white transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <!-- Page Title -->
        <h1 class="text-sm font-medium text-gray-200 flex-1">
          @yield('page-title', 'Dashboard')
        </h1>

        <!-- Right side actions -->
        <!-- Right side actions -->
<div class="flex items-center gap-2" x-data="{ profileOpen: false }">
  <!-- Dark Mode Toggle -->
<button @click="toggleDark()"
        class="w-8 h-8 rounded-lg bg-gray-800 border border-gray-700
               flex items-center justify-center text-gray-400
               hover:text-white hover:border-gray-600 transition-colors">
  <!-- Sun icon (shown in dark mode) -->
  <svg x-show="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343
             17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707
             M12 8a4 4 0 100 8 4 4 0 000-8z"/>
  </svg>
  <!-- Moon icon (shown in light mode) -->
  <svg x-show="!isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003
             9.003 0 008.354-5.646z"/>
  </svg>
</button>

  <!-- Notification Bell -->
  <button class="w-8 h-8 rounded-lg bg-gray-800 border border-gray-700
                 flex items-center justify-center text-gray-400
                 hover:text-white hover:border-gray-600 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
               6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388
               6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0
               11-6 0v-1m6 0H9"/>
    </svg>
  </button>

  <!-- Profile Dropdown -->
  <div class="relative">
    <button @click="profileOpen = !profileOpen"
            class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center
                   text-xs font-medium text-white cursor-pointer hover:bg-indigo-500
                   transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">
      {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
    </button>

    <!-- Dropdown Menu -->
    <div x-show="profileOpen"
         @click.outside="profileOpen = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 mt-2 w-52 bg-gray-900 border border-gray-800
                rounded-xl shadow-xl z-50 overflow-hidden">

      <!-- User Info -->
      <div class="px-4 py-3 border-b border-gray-800">
        <p class="text-xs font-medium text-gray-200 truncate">{{ auth()->user()->name }}</p>
        <p class="text-xs text-gray-600 truncate">{{ auth()->user()->email }}</p>
        <div class="mt-1">
          @foreach(auth()->user()->roles as $role)
            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs
                         bg-indigo-900/50 text-indigo-400 border border-indigo-800">
              {{ ucfirst($role->name) }}
            </span>
          @endforeach
        </div>
      </div>

      <!-- Menu Items -->
      <div class="p-1">
        <a href="{{ route('profile.edit') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm
                  text-gray-400 hover:bg-gray-800 hover:text-gray-200 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
          Profile Settings
        </a>

        @if(auth()->user()->hasAnyRole(['admin', 'manager']))
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm
                  text-gray-400 hover:bg-gray-800 hover:text-gray-200 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z
                     M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z
                     M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z
                     M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
          </svg>
          Dashboard
        </a>
        @endif

        <div class="border-t border-gray-800 my-1"></div>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit"
                  class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm
                         text-rose-400 hover:bg-rose-900/20 hover:text-rose-300 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0
                       01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
            </svg>
            Sign Out
          </button>
        </form>
      </div>
    </div>
  </div>

</div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-4 md:p-6 bg-gray-950">
        @yield('content')
      </main>

    </div>
    <!-- ========== END MAIN AREA ========== -->

  </div>

</body>
</html>