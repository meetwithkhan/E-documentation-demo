@extends('layouts.app')
@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
  <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">All Notifications</h3>
  </div>
  <div class="divide-y divide-gray-100 dark:divide-gray-800">
    @forelse($notifications as $notification)
    @php
      $data   = $notification->data;
      $colors = ['success'=>'bg-emerald-500','error'=>'bg-rose-500','warning'=>'bg-amber-500','info'=>'bg-indigo-500'];
      $dot    = $colors[$data['type'] ?? 'info'] ?? 'bg-indigo-500';
    @endphp
    <div class="flex items-start gap-3 px-5 py-4
                {{ $notification->read_at ? '' : 'bg-indigo-50/30 dark:bg-indigo-900/10' }}">
      <div class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ $dot }}"></div>
      <div class="flex-1">
        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $data['message'] }}</p>
        <p class="text-xs text-gray-400 dark:text-gray-600 mt-0.5">
          {{ $notification->created_at->format('D, d M Y H:i') }}
          · {{ $notification->created_at->diffForHumans() }}
        </p>
      </div>
      @if(!$notification->read_at)
        <span class="text-xs text-indigo-500 flex-shrink-0">New</span>
      @endif
    </div>
    @empty
    <div class="px-5 py-12 text-center text-sm text-gray-400 dark:text-gray-600">
      No notifications yet.
    </div>
    @endforelse
  </div>
  @if($notifications->hasPages())
  <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-800">
    {{ $notifications->links() }}
  </div>
  @endif
</div>
@endsection