@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@include('layouts.partials.alert')


@if(!auth()->user()->hasSignature())
<div class="mb-5 flex items-center justify-between gap-4 px-5 py-4
            bg-amber-50 dark:bg-amber-900/10
            border border-amber-200 dark:border-amber-800 rounded-xl">
  <div class="flex items-center gap-3">
    <svg class="w-5 h-5 text-amber-500 flex-shrink-0"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71
               3h16.94a2 2 0 000-3L12.71 3.86a2 2 0 00-3.42 0z"/>
    </svg>
    <div>
      <p class="text-sm font-medium text-amber-700 dark:text-amber-400">
        Signature required
      </p>
      <p class="text-xs text-amber-600 dark:text-amber-500">
        Upload your signature to submit logbook entries.
      </p>
    </div>
  </div>
  <a href="{{ route('profile.edit') }}"
     class="flex-shrink-0 bg-amber-500 hover:bg-amber-400 text-white
            text-xs font-medium px-4 py-2 rounded-lg transition-colors">
    Upload Now
  </a>
</div>
@endif

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
  @endphp

<!-- Greeting -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl p-6 mb-6">
  <div class="flex items-center gap-4">
    <div class="w-14 h-14 rounded-full bg-indigo-600 flex items-center justify-center
                text-xl font-semibold text-white flex-shrink-0">
      {{ strtoupper(substr($user->name, 0, 2)) }}
    </div>
    <div>
      <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
        {{ $greeting }}, {{ explode(' ', $user->name)[0] }}!
      </h2>
      <p class="text-sm text-gray-500 dark:text-gray-500 mt-0.5">
        {{ now()->format('l, F j, Y') }}
      </p>
      <div class="flex items-center gap-2 mt-1.5">
        @foreach($user->roles as $role)
          <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                       bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600
                       dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800">
            {{ $user->designation ? $user->designation->name : '—' }} 
          </span>
        @endforeach
      </div>

      <div class="flex justify-between">
        <span class="text-xs text-gray-500 dark:text-gray-600">Employee ID:</span>
        <span class="text-xs font-mono font-medium
                    text-indigo-600 dark:text-indigo-400">
          {{ $user->employee_id ?? '—' }}
        </span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-500 dark:text-gray-600">Department:</span>
        <span class="text-xs font-mono font-medium
                    text-indigo-600 dark:text-indigo-400">
          {{ $user->department ? $user->department->name : '—' }}
        </span>
      </div>
      <div class="flex justify-between">
        <span class="text-xs text-gray-500 dark:text-gray-600">Function:</span>
        <span class="text-xs font-mono font-medium
                    text-indigo-600 dark:text-indigo-400">
          {{ $user->function ? $user->function->name : '—' }}
        </span>
      </div>

      
      
    </div>
  </div>
</div>


<!-- Action Buttons -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
  <a href="{{ route('submissions.select-type') }}"
     class="flex items-center gap-4 bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-800 rounded-xl p-5 hover:border-indigo-300
            dark:hover:border-indigo-700 hover:shadow-sm transition-all group">
    <div class="w-11 h-11 rounded-xl bg-indigo-600 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4v16m8-8H4"/>
      </svg>
    </div>
    <div>
      <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
        New Logbook Entry
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">Submit a new register entry</p>
    </div>
  </a>

  <a href="{{ route('submissions.index') }}"
     class="flex items-center gap-4 bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-800 rounded-xl p-5 hover:border-teal-300
            dark:hover:border-teal-700 hover:shadow-sm transition-all group">
    <div class="w-11 h-11 rounded-xl bg-teal-600 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                 M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
      </svg>
    </div>
    <div>
      <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">
        My Entries
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">View all your submissions</p>
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
        View Datatable
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">Filter and search all entries</p>
    </div>
  </a>

  <a href="{{ route('profile.edit') }}"
     class="flex items-center gap-4 bg-white dark:bg-gray-900 border border-gray-200
            dark:border-gray-800 rounded-xl p-5 hover:border-amber-300
            dark:hover:border-amber-700 hover:shadow-sm transition-all group">
    <div class="w-11 h-11 rounded-xl bg-amber-600 flex items-center justify-center flex-shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
      </svg>
    </div>
    <div>
      <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors">
        My Profile
      </p>
      <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">Update your account settings</p>
    </div>
  </a>
</div>

<!-- Edit Requests (if any) -->
@if($editRequests->count() > 0)
<div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800
            rounded-xl p-5">
  <h3 class="text-sm font-medium text-amber-700 dark:text-amber-400 mb-3">
    ⚠ Edit Requests ({{ $editRequests->count() }})
  </h3>
  <div class="space-y-2">
    @foreach($editRequests as $sub)
    <div class="flex items-center justify-between bg-white dark:bg-gray-900 border
                border-amber-200 dark:border-amber-800/50 rounded-lg px-4 py-3">
      <div>
        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">{{ $sub->registerName() }}</p>
        <p class="text-xs text-amber-600 dark:text-amber-500 mt-0.5">
          Manager note: {{ $sub->review_note }}
        </p>
      </div>
      <a href="{{ route('submissions.edit', $sub) }}"
         class="text-xs bg-amber-600 hover:bg-amber-500 text-white px-3 py-1.5
                rounded-lg transition-colors flex-shrink-0 ml-4">
        Edit Entry
      </a>
    </div>
    @endforeach
  </div>
</div>
@endif

@endsection