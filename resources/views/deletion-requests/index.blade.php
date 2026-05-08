@extends('layouts.app')
@section('title', 'Deletion Requests')
@section('page-title', 'Deletion Requests')

@section('content')
@include('layouts.partials.alert')

<!-- Pending -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden mb-4">
  <div class="flex items-center justify-between px-5 py-4
              border-b border-gray-200 dark:border-gray-800">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">
      Pending Deletion Requests
    </h3>
    @if($pending->count() > 0)
      <span class="text-xs px-2 py-0.5 rounded-full
                   bg-rose-50 dark:bg-rose-900/50
                   text-rose-600 dark:text-rose-400
                   border border-rose-200 dark:border-rose-800">
        {{ $pending->count() }} pending
      </span>
    @endif
  </div>

  @forelse($pending as $req)
  <div class="px-5 py-4 border-b border-gray-100 dark:border-gray-800 last:border-0"
       x-data="{ open: false }">
    <div class="flex items-start justify-between gap-4">
      <div class="flex-1">
        <div class="flex items-center gap-2 mb-1">
          <div class="w-7 h-7 rounded-full bg-rose-500 flex items-center justify-center
                      text-xs font-medium text-white flex-shrink-0">
            {{ strtoupper(substr($req->targetUser->name, 0, 2)) }}
          </div>
          <div>
            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">
              {{ $req->targetUser->name }}
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-600">
              {{ $req->targetUser->email }}
              · {{ $req->targetUser->designation?->name ?? '' }}
              · {{ $req->targetUser->department?->name ?? '' }}
            </p>
          </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
          Requested by
          <span class="font-medium text-gray-700 dark:text-gray-300">
            {{ $req->requester->name }}
          </span>
          · {{ $req->created_at->diffForHumans() }}
        </p>
        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 italic">
          "{{ $req->reason }}"
        </p>
      </div>
      <button @click="open = !open"
              class="flex-shrink-0 text-xs font-medium px-3 py-1.5 rounded-lg
                     transition-colors bg-gray-100 dark:bg-gray-800
                     text-gray-600 dark:text-gray-400
                     hover:bg-gray-200 dark:hover:bg-gray-700
                     border border-gray-200 dark:border-gray-700">
        <span x-text="open ? 'Close' : 'Review'"></span>
      </button>
    </div>

    <!-- Review Panel -->
    <div x-show="open" x-transition class="mt-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

        <!-- Approve -->
        <form method="POST"
              action="{{ route('deletion-requests.approve', $req) }}"
              onsubmit="return confirm('This will permanently delete {{ $req->targetUser->name }}. Are you sure?')">
          @csrf
          <div class="mb-2">
            <textarea name="review_note" rows="2"
                      class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                             dark:border-gray-800 rounded-lg px-3 py-2 text-xs
                             text-gray-900 dark:text-gray-200 resize-none
                             focus:outline-none focus:ring-1 focus:ring-emerald-500"
                      placeholder="Approval note (optional)..."></textarea>
          </div>
          <button type="submit"
                  class="w-full bg-emerald-600 hover:bg-emerald-500 text-white
                         text-xs font-medium py-2 rounded-lg transition-colors">
            Approve & Delete User
          </button>
        </form>

        <!-- Reject -->
        <form method="POST" action="{{ route('deletion-requests.reject', $req) }}">
          @csrf
          <div class="mb-2">
            <textarea name="review_note" rows="2" required
                      class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                             dark:border-gray-800 rounded-lg px-3 py-2 text-xs
                             text-gray-900 dark:text-gray-200 resize-none
                             focus:outline-none focus:ring-1 focus:ring-rose-500"
                      placeholder="Reason for rejection (required)..."></textarea>
          </div>
          <button type="submit"
                  class="w-full bg-rose-600 hover:bg-rose-500 text-white
                         text-xs font-medium py-2 rounded-lg transition-colors">
            Reject Request
          </button>
        </form>

      </div>
    </div>
  </div>
  @empty
  <div class="px-5 py-10 text-center text-sm text-gray-400 dark:text-gray-600">
    No pending deletion requests.
  </div>
  @endforelse
</div>

<!-- Reviewed -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden">
  <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">
      Recently Reviewed
    </h3>
  </div>
  <div class="divide-y divide-gray-100 dark:divide-gray-800">
    @forelse($reviewed as $req)
    <div class="px-5 py-3 flex items-center gap-3">
      <div class="w-1.5 h-1.5 rounded-full flex-shrink-0
                  {{ $req->isApproved() ? 'bg-emerald-500' : 'bg-rose-500' }}">
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
          {{ $req->targetUser?->name ?? '[Deleted]' }}
          <span class="font-normal text-gray-400 dark:text-gray-600">
            requested by {{ $req->requester->name }}
          </span>
        </p>
        @if($req->review_note)
          <p class="text-xs text-gray-400 dark:text-gray-600 mt-0.5">
            {{ $req->review_note }}
          </p>
        @endif
      </div>
      <span class="inline-flex px-2 py-0.5 rounded border text-xs flex-shrink-0
                   {{ $req->isApproved()
                       ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800'
                       : 'bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 border-rose-200 dark:border-rose-800' }}">
        {{ ucfirst($req->status) }}
      </span>
      <span class="text-xs text-gray-400 dark:text-gray-700 flex-shrink-0">
        {{ $req->reviewed_at?->diffForHumans() }}
      </span>
    </div>
    @empty
    <div class="px-5 py-6 text-center text-xs text-gray-400 dark:text-gray-600">
      No reviewed requests yet.
    </div>
    @endforelse
  </div>
</div>

@endsection