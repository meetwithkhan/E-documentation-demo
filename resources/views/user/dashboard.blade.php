@extends('layouts.app')
@section('title', 'My Dashboard')
@section('page-title', 'My Dashboard')

@section('content')

<!-- Welcome Card -->
<div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-4">
  <div class="flex items-center gap-4">
    <div class="w-14 h-14 rounded-full bg-indigo-600 flex items-center justify-center
                text-xl font-medium text-white flex-shrink-0">
      {{ strtoupper(substr($user->name, 0, 2)) }}
    </div>
    <div>
      <h2 class="text-lg font-medium text-gray-100">Welcome, {{ $user->name }}</h2>
      <p class="text-sm text-gray-500">{{ $user->email }}</p>
      <div class="flex items-center gap-2 mt-1">
        @foreach($user->roles as $role)
          <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                       bg-gray-800 text-gray-400 border border-gray-700">
            {{ ucfirst($role->name) }}
          </span>
        @endforeach
      </div>
    </div>
  </div>
</div>

<!-- User Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <h3 class="text-sm font-medium text-gray-300 mb-3">Account Details</h3>
    <div class="space-y-3">
      <div class="flex justify-between">
        <span class="text-xs text-gray-600">Name</span>
        <span class="text-xs text-gray-300">{{ $user->name }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-600">Email</span>
        <span class="text-xs text-gray-300">{{ $user->email }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-600">Role</span>
        <span class="text-xs text-gray-300">{{ ucfirst($user->roles->first()?->name ?? 'N/A') }}</span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-600">Member Since</span>
        <span class="text-xs text-gray-300">{{ $user->created_at->format('M d, Y') }}</span>
      </div>
    </div>
  </div>

  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <h3 class="text-sm font-medium text-gray-300 mb-3">My Permissions</h3>
    <div class="flex flex-wrap gap-1.5">
      @forelse($user->getAllPermissions() as $permission)
        <span class="inline-flex items-center px-2 py-1 rounded text-xs
                     bg-gray-800 text-gray-400 border border-gray-700">
          {{ $permission->name }}
        </span>
      @empty
        <p class="text-xs text-gray-600">No permissions assigned.</p>
      @endforelse
    </div>
  </div>
</div>

<!-- Quick Link -->
<div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
  <h3 class="text-sm font-medium text-gray-300 mb-3">Quick Actions</h3>
  <a href="{{ route('profile.edit') }}"
     class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500
            text-white text-sm font-medium px-4 py-2 rounded-lg transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    Edit My Profile
  </a>
</div>

@endsection