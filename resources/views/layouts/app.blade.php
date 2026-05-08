<!DOCTYPE html>
<html lang="en" class="h-full" x-data="darkMode()" x-init="init()">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') | {{ \App\Helpers\Brand::name() }}</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
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
<body class="h-full font-sans transition-colors duration-200
             bg-gray-50 dark:bg-gray-950
             text-gray-900 dark:text-gray-200"
      x-data="{ sidebarOpen: false }">

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
           class="fixed inset-y-0 left-0 z-30 w-56 flex flex-col
                  transition-transform duration-200 ease-in-out
                  bg-white dark:bg-gray-900
                  border-r border-gray-200 dark:border-gray-800
                  lg:translate-x-0 lg:static lg:flex-shrink-0">

      <!-- Logo -->
      <div class="flex items-center gap-2.5 px-4 h-14 flex-shrink-0
                  border-b border-gray-200 dark:border-gray-800">
        <x-brand-logo size="md" />
      </div>

      <!-- Navigation -->
      <nav class="flex-1 overflow-y-auto p-3 space-y-5">

        <!-- MAIN Section -->
        <div>
          <p class="text-xs uppercase tracking-widest px-2 mb-1.5
                    text-gray-400 dark:text-gray-600">Main</p>
          <div class="space-y-0.5">
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('dashboard')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-indigo-500 flex-shrink-0"></span>
              Dashboard
            </a>

            <a href="{{ route('entries.table') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('entries*')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-blue-500 flex-shrink-0"></span>
              All Entries
            </a>
          </div>
        </div>

        <!-- USER Section -->
        @if(auth()->user()->hasRole('user'))
        <div>
          <p class="text-xs uppercase tracking-widest px-2 mb-1.5
                    text-gray-400 dark:text-gray-600">My Work</p>
          <div class="space-y-0.5">
            <a href="{{ route('submissions.select-type') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('submissions.create')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-teal-500 flex-shrink-0"></span>
              New Entry
            </a>
            <a href="{{ route('submissions.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('submissions.index')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-indigo-400 flex-shrink-0"></span>
              My Entries
            </a>
          </div>
        </div>
        @endif

        <!-- MANAGER/ADMIN Section -->
        @if(auth()->user()->hasAnyRole(['admin', 'manager']))
        <div>
          <p class="text-xs uppercase tracking-widest px-2 mb-1.5
                    text-gray-400 dark:text-gray-600">Review</p>
          <div class="space-y-0.5">
            <a href="{{ route('manager.dashboard') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('manager*')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-amber-500 flex-shrink-0"></span>
              Submissions

              @php
                $pendingCount = 0;
                if (auth()->user()->hasAnyRole(['admin', 'manager'])) {
                    if (auth()->user()->hasRole('admin')) {
                        $pendingCount = \App\Models\Submission::where('status', 'pending')->count();
                    } else {
                        $functionId   = auth()->user()->function_id;
                        $pendingCount = \App\Models\Submission::where('status', 'pending')
                            ->whereHas('user', fn($q) => $q->where('function_id', $functionId))
                            ->count();
                    }
                }
              @endphp


              @if($pendingCount > 0)
                <span class="ml-auto text-xs bg-amber-500 text-white
                             px-1.5 py-0.5 rounded-full">{{ $pendingCount }}</span>
              @endif
            </a>
          </div>
        </div>
        
        <div>
          <p class="text-xs uppercase tracking-widest px-2 mb-1.5
                    text-gray-400 dark:text-gray-600">Manage</p>
          <div class="space-y-0.5">

            <a href="{{ route('users.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('users*')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-amber-500 flex-shrink-0"></span>
              Users
            </a>



            @if(auth()->user()->hasRole('admin'))
            @php $pendingDeletions = \App\Models\DeletionRequest::where('status','pending')->count(); @endphp
                        <a href="{{ route('departments.index') }}"
              class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('departments*')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-blue-500 flex-shrink-0"></span>
              Departments
            </a>
            <a href="{{ route('designations.index') }}"
              class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('designations*')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-teal-500 flex-shrink-0"></span>
              Designations
            </a>

            <a href="{{ route('roles.index') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('roles*')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-rose-500 flex-shrink-0"></span>
              Roles
            </a>
            
            <a href="{{ route('deletion-requests.index') }}"
              class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                      {{ request()->routeIs('deletion-requests*')
                          ? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white'
                          : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800/60 hover:text-gray-900 dark:hover:text-gray-300' }}">
              <span class="w-2 h-2 rounded-sm bg-rose-500 flex-shrink-0"></span>
              Deletion Requests
              @if($pendingDeletions > 0)
                <span class="ml-auto text-xs bg-rose-500 text-white
                            px-1.5 py-0.5 rounded-full">{{ $pendingDeletions }}</span>
              @endif
            </a>
            @endif
          </div>
        </div>
        @endif

      </nav>

      <!-- User Profile Bottom -->
      <div class="flex-shrink-0 p-3 border-t border-gray-200 dark:border-gray-800">
        <div class="flex items-center gap-2.5 px-2 py-1.5 rounded-lg">
          <div class="w-7 h-7 rounded-full bg-indigo-600 flex items-center justify-center
                      text-xs font-medium text-white flex-shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
          </div>
          <a href="{{ route('profile.edit') }}" class="flex-1 min-w-0 hover:opacity-80 transition-opacity">
            <p class="text-xs font-medium truncate text-gray-700 dark:text-gray-300">
              {{ auth()->user()->name }}
            </p>
            <p class="text-xs truncate text-gray-400 dark:text-gray-600">
              @if(auth()->user()->designation)
                {{ auth()->user()->designation->name }}
                @if(auth()->user()->department)
                  · {{ auth()->user()->department->name }}
                @endif
              @else
                {{ auth()->user()->email }}
              @endif
            </p>
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" title="Logout"
                    class="transition-colors text-gray-400 dark:text-gray-600
                          hover:text-gray-700 dark:hover:text-gray-300">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0
                        01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
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
      <header class="flex-shrink-0 h-14 flex items-center gap-4 px-4
                     bg-white dark:bg-gray-900
                     border-b border-gray-200 dark:border-gray-800">

        <!-- Hamburger (mobile) -->
        <button @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden transition-colors
                       text-gray-400 dark:text-gray-400
                       hover:text-gray-700 dark:hover:text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <!-- Page Title -->
        <h1 class="text-sm font-medium flex-1 text-gray-700 dark:text-gray-200">
          @yield('page-title', 'Dashboard')
        </h1>

        <!-- Right Actions -->
        <div class="flex items-center gap-2" x-data="{ profileOpen: false }">

          <!-- Dark Mode Toggle -->
          <button @click="toggleDark()" title="Toggle theme"
                  class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                         bg-gray-100 dark:bg-gray-800
                         border border-gray-200 dark:border-gray-700
                         text-gray-500 dark:text-gray-400
                         hover:text-gray-900 dark:hover:text-white">
            <!-- Sun (shown in dark mode) -->
            <svg x-show="isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707
                       M6.343 17.657l-.707.707M17.657 17.657l-.707-.707
                       M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
            </svg>
            <!-- Moon (shown in light mode) -->
            <svg x-show="!isDark" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003
                       9.003 0 008.354-5.646z"/>
            </svg>
          </button>

    <!-- Notification Bell -->
    <div class="relative" x-data="{ open: false }" @keydown.escape.window="open = false">

      <button @click="open = !open"
              class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                    bg-gray-100 dark:bg-gray-800
                    border border-gray-200 dark:border-gray-700
                    text-gray-500 dark:text-gray-400
                    hover:text-gray-900 dark:hover:text-white relative">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0
                  00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0
                  .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @php $unread = auth()->user()->unreadNotifications->count(); @endphp
        @if($unread > 0)
          <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1
                      bg-rose-500 text-white text-xs rounded-full
                      flex items-center justify-center font-bold leading-none">
            {{ $unread > 99 ? '99+' : $unread }}
          </span>
        @endif
      </button>

      <!-- Dropdown -->
      <div x-show="open"
          @click.outside="open = false"
          x-transition:enter="transition ease-out duration-150"
          x-transition:enter-start="opacity-0 translate-y-1 scale-95"
          x-transition:enter-end="opacity-100 translate-y-0 scale-100"
          x-transition:leave="transition ease-in duration-100"
          x-transition:leave-start="opacity-100 translate-y-0 scale-100"
          x-transition:leave-end="opacity-0 translate-y-1 scale-95"
          class="absolute right-0 mt-2 z-50"
          style="width: 380px;">

        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-2xl
                    border border-gray-200 dark:border-gray-800 overflow-hidden">

          <!-- Header -->
          <div class="flex items-center justify-between px-5 py-4
                      border-b border-gray-100 dark:border-gray-800
                      bg-gray-50 dark:bg-gray-800/50">
            <div class="flex items-center gap-2">
              <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                        6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388
                        6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3
                        0 11-6 0v-1m6 0H9"/>
              </svg>
              <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
                Notifications
              </p>
              @if($unread > 0)
                <span class="bg-rose-500 text-white text-xs font-bold
                            px-1.5 py-0.5 rounded-full leading-none">
                  {{ $unread }}
                </span>
              @endif
            </div>
            @if($unread > 0)
              <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit"
                        class="text-xs text-indigo-600 dark:text-indigo-400
                              hover:text-indigo-800 dark:hover:text-indigo-300
                              font-medium transition-colors">
                  Mark all read
                </button>
              </form>
            @endif
          </div>

          <!-- Notification List -->
          <div class="divide-y divide-gray-100 dark:divide-gray-800"
              style="max-height: 420px; overflow-y: auto;">

            @php
              $notifications = auth()->user()->notifications()->latest()->take(15)->get();
              $typeConfig = [
                'success' => ['bg' => 'bg-emerald-500', 'light' => 'bg-emerald-50 dark:bg-emerald-900/20', 'icon_color' => 'text-emerald-500 dark:text-emerald-400', 'border' => 'border-emerald-200 dark:border-emerald-800/50'],
                'error'   => ['bg' => 'bg-rose-500',    'light' => 'bg-rose-50 dark:bg-rose-900/20',       'icon_color' => 'text-rose-500 dark:text-rose-400',       'border' => 'border-rose-200 dark:border-rose-800/50'],
                'warning' => ['bg' => 'bg-amber-500',   'light' => 'bg-amber-50 dark:bg-amber-900/20',     'icon_color' => 'text-amber-500 dark:text-amber-400',     'border' => 'border-amber-200 dark:border-amber-800/50'],
                'info'    => ['bg' => 'bg-indigo-500',  'light' => 'bg-indigo-50 dark:bg-indigo-900/20',   'icon_color' => 'text-indigo-500 dark:text-indigo-400',   'border' => 'border-indigo-200 dark:border-indigo-800/50'],
              ];

              $icons = [
                'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
                'error'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>',
                'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 000-3L12.71 3.86a2 2 0 00-3.42 0z"/>',
                'info'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
              ];
            @endphp

            @forelse($notifications as $notification)
            @php
              $data   = $notification->data;
              $type   = $data['type'] ?? 'info';
              $cfg    = $typeConfig[$type] ?? $typeConfig['info'];
              $icon   = $icons[$type] ?? $icons['info'];
              $isNew  = !$notification->read_at;
            @endphp

            <a href="{{ $data['url'] ?? '#' }}"
              onclick="markRead('{{ $notification->id }}')"
              class="flex items-start gap-3.5 px-5 py-4 transition-all duration-150 block
                      {{ $isNew
                          ? 'bg-indigo-50/60 dark:bg-indigo-900/10 hover:bg-indigo-50 dark:hover:bg-indigo-900/20'
                          : 'hover:bg-gray-50 dark:hover:bg-gray-800/50' }}">

              <!-- Icon bubble -->
              <div class="w-9 h-9 rounded-xl flex items-center justify-center
                          flex-shrink-0 mt-0.5 {{ $cfg['light'] }}
                          border {{ $cfg['border'] }}">
                <svg class="w-4 h-4 {{ $cfg['icon_color'] }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  {!! $icon !!}
                </svg>
              </div>

              <!-- Content -->
              <div class="flex-1 min-w-0">
                <p class="text-xs leading-relaxed
                          {{ $isNew
                              ? 'text-gray-800 dark:text-gray-200 font-medium'
                              : 'text-gray-600 dark:text-gray-400' }}">
                  {{ $data['message'] }}
                </p>

                @if(!empty($data['register_name']))
                  <span class="inline-flex items-center mt-1 px-2 py-0.5 rounded text-xs
                              bg-gray-100 dark:bg-gray-800
                              text-gray-500 dark:text-gray-500
                              border border-gray-200 dark:border-gray-700">
                    {{ $data['register_name'] }}
                  </span>
                @endif

                <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                  {{ $notification->created_at->diffForHumans() }}
                </p>
              </div>

              <!-- Unread dot -->
              @if($isNew)
                <div class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0 mt-2"></div>
              @endif
            </a>

            @empty
            <div class="flex flex-col items-center justify-center py-12 px-5">
              <div class="w-14 h-14 rounded-full bg-gray-100 dark:bg-gray-800
                          flex items-center justify-center mb-3">
                <svg class="w-7 h-7 text-gray-300 dark:text-gray-600"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                          6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388
                          6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3
                          0 11-6 0v-1m6 0H9"/>
                </svg>
              </div>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                All caught up!
              </p>
              <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
                No notifications yet
              </p>
            </div>
            @endforelse
          </div>

          <!-- Footer -->
          @if($notifications->count() > 0)
          <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-800
                      bg-gray-50 dark:bg-gray-800/50 flex items-center justify-between">
            <span class="text-xs text-gray-400 dark:text-gray-600">
              Showing {{ min($notifications->count(), 15) }} notifications
            </span>
            <a href="{{ route('notifications.index') }}"
              class="text-xs font-medium text-indigo-600 dark:text-indigo-400
                      hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors
                      flex items-center gap-1">
              View all
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>
          @endif

        </div>
      </div>
    </div>

          @push('scripts')
          <script>
          function markRead(id) {
            fetch(`/notifications/${id}/read`, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
              }
            });
          }
          </script>
          @endpush

          <!-- Profile Dropdown -->
          <div class="relative">
            <button @click="profileOpen = !profileOpen"
                    class="w-8 h-8 rounded-full flex items-center justify-center
                           text-xs font-medium text-white cursor-pointer transition-colors
                           bg-indigo-600 hover:bg-indigo-500
                           focus:outline-none focus:ring-2 focus:ring-indigo-500">
              {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </button>

            <!-- Dropdown -->
            <div x-show="profileOpen"
                 @click.outside="profileOpen = false"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-52 rounded-xl shadow-xl z-50 overflow-hidden
                        bg-white dark:bg-gray-900
                        border border-gray-200 dark:border-gray-800">

              <!-- User Info -->
              <!-- User Info -->
              <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">

                <!-- Avatar + Name -->
                <div class="flex items-center gap-2.5 mb-2">
                  <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center
                              text-sm font-semibold text-white flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                  </div>
                  <div class="min-w-0">
                    <p class="text-xs font-semibold truncate text-gray-800 dark:text-gray-200">
                      {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs truncate text-gray-400 dark:text-gray-600">
                      {{ auth()->user()->email }}
                    </p>
                  </div>
                </div>

                <!-- Greeting -->
                @php
                  $hour = now()->format('H');
                  if ($hour >= 5 && $hour < 12) {
                      $greeting = '🌤 Good morning';
                  } elseif ($hour >= 12 && $hour < 17) {
                      $greeting = '☀️ Good afternoon';
                  } elseif ($hour >= 17 && $hour < 21) {
                      $greeting = '🌆 Good evening';
                  } else {
                      $greeting = '🌙 Good night';
                  }
                  //$greeting = ($hour > 6 && $hour < 12 ) ? '🌤 Good morning' : ($hour < 17 ? '☀️ Good afternoon' : ($hour < 19 ? '🌆 Good evening' : '🌙 Good night'));
                @endphp
                <p class="text-xs text-gray-500 dark:text-gray-500 mb-2">{{ $greeting }}</p>


                @if(auth()->user()->employee_id)
                <div class="flex items-center gap-1.5 mb-2">
                  <svg class="w-3 h-3 text-gray-400 dark:text-gray-600 flex-shrink-0"
                      fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0
                            00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0
                            11-4 0 2 2 0 014 0zm-4 0a2 2 0 104 0"/>
                  </svg>
                  <span class="text-xs font-mono font-medium
                              text-indigo-600 dark:text-indigo-400">
                    {{ auth()->user()->employee_id }}
                  </span>
                </div>
                @endif

                <!-- Role -->
                <!-- <div class="flex flex-wrap gap-1 mb-2">
                  @foreach(auth()->user()->roles as $role)
                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs
                                bg-indigo-50 dark:bg-indigo-900/50
                                text-indigo-600 dark:text-indigo-400
                                border border-indigo-200 dark:border-indigo-800">
                      {{ ucfirst($role->name) }}
                    </span>
                  @endforeach
                </div> -->

                <!-- Department / Function / Designation -->
                <div class="space-y-1">
                  @if(auth()->user()->designation)
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 text-gray-400 dark:text-gray-600 flex-shrink-0"
                          fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                      <span class="text-xs text-gray-500 dark:text-gray-500">
                        {{ auth()->user()->designation->name }}
                      </span>
                    </div>
                  @endif

                  @if(auth()->user()->department)
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 text-gray-400 dark:text-gray-600 flex-shrink-0"
                          fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2
                                0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5
                                10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                      </svg>
                      <span class="text-xs text-gray-500 dark:text-gray-500">
                        {{ auth()->user()->department->name }}
                      </span>
                    </div>
                  @endif

                  @if(auth()->user()->function)
                    <div class="flex items-center gap-1.5">
                      <svg class="w-3 h-3 text-gray-400 dark:text-gray-600 flex-shrink-0"
                          fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0
                                00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                      </svg>
                      <span class="text-xs text-gray-500 dark:text-gray-500">
                        {{ auth()->user()->function->name }}
                      </span>
                    </div>
                  @endif
                </div>

              </div>
              <!-- Menu -->
              <div class="p-1">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                          text-gray-600 dark:text-gray-400
                          hover:bg-gray-100 dark:hover:bg-gray-800
                          hover:text-gray-900 dark:hover:text-gray-200">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                  </svg>
                  Profile Settings
                </a>

                @if(auth()->user()->hasAnyRole(['admin', 'manager']))
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors
                          text-gray-600 dark:text-gray-400
                          hover:bg-gray-100 dark:hover:bg-gray-800
                          hover:text-gray-900 dark:hover:text-gray-200">
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

                <div class="border-t border-gray-100 dark:border-gray-800 my-1"></div>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit"
                          class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg
                                 text-sm transition-colors
                                 text-rose-500 dark:text-rose-400
                                 hover:bg-rose-50 dark:hover:bg-rose-900/20
                                 hover:text-rose-600 dark:hover:text-rose-300">
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
          <!-- End Profile Dropdown -->

        </div>
        <!-- End Right Actions -->

      </header>
      <!-- End Top Bar -->

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-4 md:p-6
                   bg-gray-50 dark:bg-gray-950">
        @yield('content')
      </main>

    </div>
    <!-- ========== END MAIN AREA ========== -->

  </div>
 @stack('scripts')
</body>
</html>