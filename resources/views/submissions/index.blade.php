@extends('layouts.app')
@section('title', 'My Entries')
@section('page-title', 'My Logbook Entries')

@section('content')
@include('layouts.partials.alert')

<div class="space-y-4">

  <!-- Top Bar -->
  <div class="flex items-center justify-between">
    <p class="text-sm text-gray-500 dark:text-gray-500">
      {{ $submissions->total() }} {{ Str::plural('entry', $submissions->total()) }} found
    </p>
    <a href="{{ route('submissions.create') }}"
       class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500
              text-white text-xs font-medium px-3 py-2 rounded-lg transition-colors">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      New Entry
    </a>
  </div>

  <!-- Stat Cards -->
<div class="grid grid-cols-3 gap-4 mb-6">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center">
    <p class="text-2xl font-semibold text-amber-500">{{ $stats['pending'] }}</p>
    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Pending</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center">
    <p class="text-2xl font-semibold text-emerald-500">{{ $stats['approved'] }}</p>
    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Approved</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center">
    <p class="text-2xl font-semibold text-rose-500">{{ $stats['rejected'] }}</p>
    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Rejected</p>
  </div>
</div>

  <!-- Entries -->
@forelse($submissions as $sub)
@php $config = $sub->registerConfig(); $fields = $config['fields'] ?? []; @endphp

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden"
     x-data="{ open: false }">

  <!-- Entry Header -->
  <div class="flex items-center justify-between px-5 py-3
              bg-gray-50 dark:bg-gray-800/40
              border-b border-gray-200 dark:border-gray-800">
    <div class="flex items-center gap-3 flex-wrap">

      <!-- Register Type Badge -->
      <span class="text-xs font-medium px-2 py-1 rounded-lg
                   bg-gray-100 dark:bg-gray-800
                   text-gray-600 dark:text-gray-400
                   border border-gray-200 dark:border-gray-700">
        {{ $sub->registerName() }}
      </span>

      <!-- Status Badge -->
      @php
        $badge = [
          'pending'        => 'bg-amber-50 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 border-amber-200 dark:border-amber-800',
          'approved'       => 'bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
          'rejected'       => 'bg-rose-50 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 border-rose-200 dark:border-rose-800',
          'edit_requested' => 'bg-orange-50 dark:bg-orange-900/50 text-orange-600 dark:text-orange-400 border-orange-200 dark:border-orange-800',
        ][$sub->status] ?? '';
      @endphp
      <span class="inline-flex px-2 py-0.5 rounded border text-xs {{ $badge }}">
        {{ ucfirst(str_replace('_', ' ', $sub->status)) }}
      </span>

      <!-- Submitted time -->
      <span class="text-xs text-gray-400 dark:text-gray-600">
        {{ $sub->created_at->diffForHumans() }}
      </span>
    </div>

    <!-- Right side actions -->
    <div class="flex items-center gap-3">

      @if($sub->status === 'edit_requested')
        <a href="{{ route('submissions.edit', $sub) }}"
           class="text-xs bg-orange-500 hover:bg-orange-400 text-white
                  px-3 py-1.5 rounded-lg transition-colors font-medium">
          Edit Entry
        </a>
      @endif

      @if($sub->isPending())
        <form method="POST" action="{{ route('submissions.destroy', $sub) }}"
              onsubmit="return confirm('Delete this entry?')">
          @csrf @method('DELETE')
          <button type="submit"
                  class="text-xs transition-colors
                         text-rose-500 dark:text-rose-500
                         hover:text-rose-700 dark:hover:text-rose-400">
            Delete
          </button>
        </form>
      @endif

      <!-- Toggle button -->
      <button @click="open = !open"
              class="flex items-center gap-1 text-xs font-medium px-3 py-1.5
                     rounded-lg transition-colors
                     bg-indigo-50 dark:bg-indigo-900/30
                     text-indigo-600 dark:text-indigo-400
                     hover:bg-indigo-100 dark:hover:bg-indigo-900/50
                     border border-indigo-200 dark:border-indigo-800">
        <span x-text="open ? 'Hide' : 'View'"></span>
        <svg class="w-3 h-3 transition-transform duration-200"
             :class="open ? 'rotate-180' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Collapsible Content -->
  <div x-show="open"
       x-transition:enter="transition ease-out duration-150"
       x-transition:enter-start="opacity-0 -translate-y-1"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-100"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 -translate-y-1">

    <!-- Edit Request Notice -->
    @if($sub->status === 'edit_requested' && $sub->review_note)
    <div class="px-5 py-3 border-b border-orange-200 dark:border-orange-900/50
                bg-orange-50 dark:bg-orange-900/10">
      <p class="text-xs font-medium text-orange-600 dark:text-orange-400 mb-0.5">
        ⚠ Manager requested changes:
      </p>
      <p class="text-xs text-orange-700 dark:text-orange-300">{{ $sub->review_note }}</p>
    </div>
    @endif

    <!-- Rejection Note -->
    @if($sub->status === 'rejected' && $sub->review_note)
    <div class="px-5 py-3 border-b border-rose-200 dark:border-rose-900/50
                bg-rose-50 dark:bg-rose-900/10">
      <p class="text-xs font-medium text-rose-600 dark:text-rose-400 mb-0.5">
        Rejection reason:
      </p>
      <p class="text-xs text-rose-700 dark:text-rose-300">{{ $sub->review_note }}</p>
    </div>
    @endif

    <!-- Field Values Table -->
    <div class="overflow-x-auto">
      <table class="w-full text-xs">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800">
            @foreach($fields as $field)
              <th class="text-left px-4 py-2.5 font-medium whitespace-nowrap
                         text-gray-400 dark:text-gray-600">
                {{ $field['label'] }}
              </th>
            @endforeach

            @if($sub->isApproved() && !empty($config['review_fields']))
              @foreach($config['review_fields'] as $rf)
                <th class="text-left px-4 py-2.5 font-medium whitespace-nowrap
                           text-emerald-600 dark:text-emerald-700">
                  {{ $rf['label'] }}
                </th>
              @endforeach
            @endif
          </tr>
        </thead>
        <tbody>
          <tr>
            @foreach($fields as $field)
              <td class="px-4 py-3 whitespace-nowrap
                         text-gray-700 dark:text-gray-300">
                {{ $sub->field($field['name']) }}
              </td>
            @endforeach

            @if($sub->isApproved() && !empty($config['review_fields']))
              @foreach($config['review_fields'] as $rf)
                <td class="px-4 py-3 whitespace-nowrap
                           text-emerald-600 dark:text-emerald-400">
                  {{ $sub->reviewField($rf['name']) }}
                </td>
              @endforeach
            @endif
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Approval Note -->
    @if($sub->isApproved() && $sub->review_note)
    <div class="px-5 py-2.5 border-t border-gray-100 dark:border-gray-800
                bg-emerald-50 dark:bg-emerald-900/10">
      <p class="text-xs text-emerald-600 dark:text-emerald-500">
        Note: {{ $sub->review_note }}
      </p>
    </div>
    @endif

  </div>
  <!-- End Collapsible -->

</div>
@empty
<!-- Empty State -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl px-5 py-16 text-center">
  <div class="w-12 h-12 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center
              justify-center mx-auto mb-4">
    <svg class="w-6 h-6 text-gray-400 dark:text-gray-600" fill="none"
         stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0
               00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
    </svg>
  </div>
  <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">No entries yet</p>
  <p class="text-xs text-gray-400 dark:text-gray-600 mb-4">
    Start by submitting your first logbook entry
  </p>
  <a href="{{ route('submissions.create') }}"
     class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500
            text-white text-xs font-medium px-4 py-2 rounded-lg transition-colors">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4v16m8-8H4"/>
    </svg>
    New Entry
  </a>
</div>
@endforelse

  <!-- Pagination -->
  @if($submissions->hasPages())
  <div class="mt-2">
    {{ $submissions->links() }}
  </div>
  @endif

</div>
@endsection