@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@include('layouts.partials.alert')

@php
  $hour = now()->format('H');
  if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good morning';
    } elseif ($hour >= 12 && $hour < 17) {
        $greeting = 'Good afternoon';
    } elseif ($hour >= 17 && $hour < 21) {
        $greeting = 'Good evening';
    } else {
        $greeting = 'Good night';
    }
    $authUser = auth()->user()->load('designation', 'department', 'function');
@endphp

<!-- Greeting -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl p-6 mb-6">
  <div class="flex items-center gap-4">
    <div class="w-14 h-14 rounded-full bg-indigo-600 flex items-center justify-center
                text-xl font-semibold text-white flex-shrink-0">
      {{ strtoupper(substr($authUser->name, 0, 2)) }}
    </div>
    <div>
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
        {{ $greeting }}, {{ explode(' ', $authUser->name)[0] }}!
      </h2>
      <p class="text-sm text-gray-500 dark:text-gray-500 mt-0.5">
        {{ now()->format('l, F j, Y') }}
      </p>
      <div class="flex items-center gap-2 mt-1.5">
        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                     bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600
                     dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
          {{ $authUser->designation?->name ?? '—' }}
        </span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-500 dark:text-gray-600">Employee ID:</span>
        <span class="text-xs font-mono font-medium text-indigo-600 dark:text-indigo-400">
          {{ $authUser->employee_id ?? '—' }}
        </span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-500 dark:text-gray-600">Department:</span>
        <span class="text-xs font-mono font-medium text-indigo-600 dark:text-indigo-400">
          {{ $authUser->department?->name ?? '—' }}
        </span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-500 dark:text-gray-600">Function:</span>
        <span class="text-xs font-mono font-medium text-indigo-600 dark:text-indigo-400">
          {{ $authUser->function?->name ?? '—' }}
        </span>
      </div>
    </div>
  </div>
</div>

<!-- Stats -->
<!-- <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-4 text-center">
    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</p>
    <p class="text-xs text-gray-500 mt-1">Total Entries</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-amber-200 dark:border-amber-900/40
              rounded-xl p-4 text-center">
    <p class="text-2xl font-semibold text-amber-500">{{ $stats['pending'] }}</p>
    <p class="text-xs text-gray-500 mt-1">Pending Review</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-emerald-200 dark:border-emerald-900/40
              rounded-xl p-4 text-center">
    <p class="text-2xl font-semibold text-emerald-500">{{ $stats['approved'] }}</p>
    <p class="text-xs text-gray-500 mt-1">Approved</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-rose-200 dark:border-rose-900/40
              rounded-xl p-4 text-center">
    <p class="text-2xl font-semibold text-rose-500">{{ $stats['rejected'] }}</p>
    <p class="text-xs text-gray-500 mt-1">Rejected</p>
  </div>
</div> -->

<!-- Action Buttons -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

  <a href="{{ route('manager.dashboard') }}"
     class="flex items-center gap-4 bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-800 rounded-xl p-5 hover:border-amber-300
            dark:hover:border-amber-700 hover:shadow-sm transition-all group">
    <div class="w-11 h-11 rounded-xl bg-amber-500 flex items-center justify-center
                flex-shrink-0 relative">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      @if($stats['pending'] > 0)
        <span class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-rose-500 text-white
                     text-xs rounded-full flex items-center justify-center font-medium">
          {{ $stats['pending'] }}
        </span>
      @endif
    </div>
    <div>
      <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
        Review Submissions
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
        @if($stats['pending'] > 0)
          {{ $stats['pending'] }} entries awaiting your review
        @else
          No pending entries
        @endif
      </p>
    </div>
  </a>

  <a href="{{ route('entries.table') }}"
     class="flex items-center gap-4 bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-800 rounded-xl p-5 hover:border-blue-300
            dark:hover:border-blue-700 hover:shadow-sm transition-all group">
    <div class="w-11 h-11 rounded-xl bg-blue-600 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M3 14h18M10 3v18M14 3v18"/>
      </svg>
    </div>
    <div>
      <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
        All Entries Datatable
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
        Filter and search all logbook entries
      </p>
    </div>
  </a>

  <a href="{{ route('users.index') }}"
     class="flex items-center gap-4 bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-800 rounded-xl p-5 hover:border-indigo-300
            dark:hover:border-indigo-700 hover:shadow-sm transition-all group">
    <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857
                 M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857
                 m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
      </svg>
    </div>
    <div>
      <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
        Manage Users
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
        View and manage user accounts
      </p>
    </div>
  </a>

  <a href="{{ route('profile.edit') }}"
     class="flex items-center gap-4 bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-800 rounded-xl p-5 hover:border-teal-300
            dark:hover:border-teal-700 hover:shadow-sm transition-all group">
    <div class="w-11 h-11 rounded-xl bg-teal-600 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
      </svg>
    </div>
    <div>
      <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
        My Profile
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
        Update your account settings
      </p>
    </div>
  </a>

</div>

@endsection