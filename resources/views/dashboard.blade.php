@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
  @foreach ([
    ['label' => 'Total Users',  'value' => '4,821',  'change' => '+12%', 'up' => true],
    ['label' => 'Revenue',      'value' => '$24.5k', 'change' => '+8.2%', 'up' => true],
    ['label' => 'Orders',       'value' => '1,294',  'change' => '-3.1%', 'up' => false],
    ['label' => 'Uptime',       'value' => '98.2%',  'change' => '+0.4%', 'up' => true],
  ] as $stat)
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
    <p class="text-xs text-gray-500 mb-1">{{ $stat['label'] }}</p>
    <p class="text-2xl font-medium text-gray-100">{{ $stat['value'] }}</p>
    <p class="text-xs mt-1 {{ $stat['up'] ? 'text-emerald-400' : 'text-rose-400' }}">
      {{ $stat['change'] }} this month
    </p>
  </div>
  @endforeach
</div>

<!-- Two Column Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">

  <!-- Recent Activity -->
  <div class="lg:col-span-2 bg-gray-900 border border-gray-800 rounded-xl p-5">
    <h3 class="text-sm font-medium text-gray-300 mb-4">Recent Activity</h3>
    <div class="space-y-3">
      @foreach ([
        ['name' => 'Alice Rahman',  'action' => 'Created a new account', 'time' => '2 min ago',  'color' => 'bg-indigo-500'],
        ['name' => 'Bob Hasan',     'action' => 'Updated profile info',   'time' => '18 min ago', 'color' => 'bg-teal-500'],
        ['name' => 'Mila Chen',     'action' => 'Placed a new order',     'time' => '1 hr ago',   'color' => 'bg-amber-500'],
        ['name' => 'Dev Patel',     'action' => 'Submitted a report',     'time' => '3 hr ago',   'color' => 'bg-rose-500'],
        ['name' => 'Sara Kim',      'action' => 'Changed password',       'time' => 'Yesterday',  'color' => 'bg-blue-500'],
      ] as $item)
      <div class="flex items-center gap-3">
        <div class="w-7 h-7 rounded-full {{ $item['color'] }} flex items-center justify-center
                    text-xs font-medium text-white flex-shrink-0">
          {{ strtoupper(substr($item['name'], 0, 1)) }}
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm text-gray-300 font-medium">{{ $item['name'] }}</p>
          <p class="text-xs text-gray-600">{{ $item['action'] }}</p>
        </div>
        <span class="text-xs text-gray-600 flex-shrink-0">{{ $item['time'] }}</span>
      </div>
      @endforeach
    </div>
  </div>

  <!-- Quick Stats -->
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-5">
    <h3 class="text-sm font-medium text-gray-300 mb-4">Quick Stats</h3>
    <div class="space-y-4">
      @foreach ([
        ['label' => 'Storage Used',  'pct' => 68, 'color' => 'bg-indigo-500'],
        ['label' => 'CPU Load',      'pct' => 34, 'color' => 'bg-teal-500'],
        ['label' => 'Memory',        'pct' => 81, 'color' => 'bg-rose-500'],
        ['label' => 'Bandwidth',     'pct' => 52, 'color' => 'bg-amber-500'],
      ] as $stat)
      <div>
        <div class="flex justify-between mb-1">
          <span class="text-xs text-gray-500">{{ $stat['label'] }}</span>
          <span class="text-xs text-gray-400">{{ $stat['pct'] }}%</span>
        </div>
        <div class="w-full bg-gray-800 rounded-full h-1.5">
          <div class="{{ $stat['color'] }} h-1.5 rounded-full" style="width: {{ $stat['pct'] }}%"></div>
        </div>
      </div>
      @endforeach
    </div>
  </div>

</div>

@endsection