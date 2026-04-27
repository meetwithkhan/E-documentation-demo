@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
    <p class="text-xs text-gray-500 mb-1">Total Users</p>
    <p class="text-2xl font-medium text-gray-100">{{ $stats['total_users'] }}</p>
    <p class="text-xs mt-1 text-indigo-400">All registered users</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
    <p class="text-xs text-gray-500 mb-1">Total Roles</p>
    <p class="text-2xl font-medium text-gray-100">{{ $stats['total_roles'] }}</p>
    <p class="text-xs mt-1 text-teal-400">Permission groups</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
    <p class="text-xs text-gray-500 mb-1">Admins</p>
    <p class="text-2xl font-medium text-gray-100">{{ $stats['admins'] }}</p>
    <p class="text-xs mt-1 text-amber-400">Full access users</p>
  </div>
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
    <p class="text-xs text-gray-500 mb-1">Managers</p>
    <p class="text-2xl font-medium text-gray-100">{{ $stats['managers'] }}</p>
    <p class="text-xs mt-1 text-rose-400">Manager role users</p>
  </div>
</div>

<!-- Recent Users + Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

  <!-- Recent Users -->
  <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-xl p-5">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-sm font-medium text-gray-300">Recent Users</h3>
      <a href="{{ route('users.index') }}"
         class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">
        View all →
      </a>
    </div>
    <div class="space-y-3">
      @foreach($recentUsers as $user)
      <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center
                    text-xs font-medium text-white flex-shrink-0">
          {{ strtoupper(substr($user->name, 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm text-gray-300 font-medium truncate">{{ $user->name }}</p>
          <p class="text-xs text-gray-600 truncate">{{ $user->email }}</p>
        </div>
        <div class="flex items-center gap-2">
          @foreach($user->roles as $role)
            @php
              $colors = [
                'admin'   => 'bg-indigo-900/50 text-indigo-400 border-indigo-800',
                'manager' => 'bg-amber-900/50 text-amber-400 border-amber-800',
                'user'    => 'bg-gray-800 text-gray-400 border-gray-700',
              ];
              $color = $colors[$role->name] ?? 'bg-gray-800 text-gray-400 border-gray-700';
            @endphp
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs border {{ $color }}">
              {{ ucfirst($role->name) }}
            </span>
          @endforeach
          <span class="text-xs text-gray-600">{{ $user->created_at->diffForHumans() }}</span>
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <h3 class="text-sm font-medium text-gray-300 mb-4">Quick Actions</h3>
    <div class="space-y-2">
      <a href="{{ route('users.create') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-gray-800/60
                hover:bg-gray-800 transition-colors group">
        <div class="w-7 h-7 rounded-lg bg-indigo-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
          </svg>
        </div>
        <span class="text-sm text-gray-400 group-hover:text-gray-200 transition-colors">Add New User</span>
      </a>
      <a href="{{ route('roles.create') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-gray-800/60
                hover:bg-gray-800 transition-colors group">
        <div class="w-7 h-7 rounded-lg bg-teal-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955
                     11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824
                     10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
          </svg>
        </div>
        <span class="text-sm text-gray-400 group-hover:text-gray-200 transition-colors">Create Role</span>
      </a>
      <a href="{{ route('profile.edit') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-gray-800/60
                hover:bg-gray-800 transition-colors group">
        <div class="w-7 h-7 rounded-lg bg-amber-600 flex items-center justify-center flex-shrink-0">
          <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </div>
        <span class="text-sm text-gray-400 group-hover:text-gray-200 transition-colors">Edit Profile</span>
      </a>
    </div>
  </div>

</div>

@endsection