@extends('layouts.app')
@section('title', 'Review Entries')
@section('page-title', 'Review Logbook Entries')

@section('content')
@include('layouts.partials.alert')

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6"> 
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 text-center">
    <p class="text-xs text-gray-500 mb-1">Total</p>
    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['total'] }}</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-amber-200 dark:border-amber-900/40 rounded-xl p-4 text-center">
    <p class="text-xs text-gray-500 mb-1">Pending</p>
    <p class="text-2xl font-semibold text-amber-500">{{ $stats['pending'] }}</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-emerald-200 dark:border-emerald-900/40 rounded-xl p-4 text-center">
    <p class="text-xs text-gray-500 mb-1">Approved</p>
    <p class="text-2xl font-semibold text-emerald-500">{{ $stats['approved'] }}</p>
  </div>
  <div class="bg-white dark:bg-gray-900 border border-rose-200 dark:border-rose-900/40 rounded-xl p-4 text-center">
    <p class="text-xs text-gray-500 mb-1">Rejected</p>
    <p class="text-2xl font-semibold text-rose-500">{{ $stats['rejected'] }}</p>
  </div>
</div>

<!-- Pending Entries -->
<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden mb-4"
     x-data="paginatedSection('pending', {{ $pending->count() }}, 5)">

  <div class="flex items-center justify-between px-5 py-4
              border-b border-gray-200 dark:border-gray-800">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">Pending Entries</h3>
    <div class="flex items-center gap-3">
      @if($stats['pending'] > 0)
        <span class="text-xs px-2 py-0.5 rounded-full
                     bg-amber-50 dark:bg-amber-900/50
                     text-amber-600 dark:text-amber-400
                     border border-amber-200 dark:border-amber-800">
          {{ $stats['pending'] }} awaiting
        </span>
      @endif
      <!-- Per page selector -->
      <div class="flex items-center gap-1.5">
        <label class="text-xs text-gray-400 dark:text-gray-600">Show</label>
        <select x-model.number="perPage" @change="currentPage = 1"
                -class="text-xs bg-gray-50 dark:bg-gray-950 border border-gray-200
       dark:border-gray-800 rounded px-2 py-1
       text-gray-700 dark:text-gray-300 focus:outline-none appearance-none">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
          <option value="50">50</option>
        </select>
      </div>
    </div>
  </div>

  @forelse($pending as $index => $sub)
  @php
    $config       = $sub->registerConfig();
    $fields       = $config['fields'] ?? [];
    $reviewFields = $config['review_fields'] ?? [];
  @endphp

  <div class="border-b border-gray-100 dark:border-gray-800/60 last:border-0"
       x-show="isVisible({{ $index }})"
       x-data="{ open: false }">

    <!-- Summary Row -->
    <div class="px-5 py-4 flex items-start justify-between gap-4">
      <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 flex-wrap mb-1.5">
          <span class="text-xs px-2 py-0.5 rounded
                       bg-gray-100 dark:bg-gray-800
                       text-gray-600 dark:text-gray-400
                       border border-gray-200 dark:border-gray-700">
            {{ $sub->registerName() }}
          </span>
          <span class="text-xs text-gray-400 dark:text-gray-600">
            by {{ $sub->user->name }}
          </span>
          <span class="text-xs text-gray-400 dark:text-gray-700">
            {{ $sub->created_at->diffForHumans() }}
          </span>
        </div>
        <div class="flex flex-wrap gap-x-4 gap-y-0.5">
          @foreach(array_slice($fields, 0, 5) as $field)
            <span class="text-xs text-gray-400 dark:text-gray-600">
              {{ $field['label'] }}:
              <span class="text-gray-700 dark:text-gray-400 font-medium">
                {{ $sub->field($field['name']) }}
              </span>
            </span>
          @endforeach
        </div>
      </div>
      <div class="flex items-center gap-2 flex-shrink-0">
        <!-- View toggle -->
        <button @click="open = !open"
                class="flex items-center gap-1 text-xs font-medium px-3 py-1.5
                       rounded-lg transition-colors
                       bg-gray-100 dark:bg-gray-800
                       text-gray-600 dark:text-gray-400
                       hover:bg-gray-200 dark:hover:bg-gray-700
                       border border-gray-200 dark:border-gray-700">
          <span x-text="open ? 'Hide' : 'View'"></span>
          <svg class="w-3 h-3 transition-transform duration-200"
               :class="open ? 'rotate-180' : ''"
               fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <!-- Review toggle -->
        <button @click="open = true; $nextTick(() => document.getElementById('review-{{ $sub->id }}').scrollIntoView({behavior:'smooth'}))"
                class="text-xs font-medium px-3 py-1.5 rounded-lg transition-colors
                       bg-indigo-600 hover:bg-indigo-500 text-white">
          Review
        </button>
      </div>
    </div>

    <!-- Collapsible Detail + Review Panel -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">

      <div class="px-5 pb-5">
        <div class="bg-gray-50 dark:bg-gray-950 border border-gray-200
                    dark:border-gray-800 rounded-xl p-5">

          <!-- Full Entry Table -->
          <p class="text-xs uppercase tracking-widest mb-3
                    text-gray-400 dark:text-gray-600">Full Entry</p>
          <div class="overflow-x-auto mb-5">
            <table class="w-full text-xs border border-gray-200 dark:border-gray-800
                          rounded-lg overflow-hidden">
              <thead>
                <tr class="bg-gray-100 dark:bg-gray-800">
                  @foreach($fields as $field)
                    <th class="text-left px-3 py-2 font-medium whitespace-nowrap
                               text-gray-500 dark:text-gray-500">
                      {{ $field['label'] }}
                    </th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                <tr class="bg-white dark:bg-gray-900">
                  @foreach($fields as $field)
                    <td class="px-3 py-2.5 border-t border-gray-100 dark:border-gray-800
                               whitespace-nowrap text-gray-700 dark:text-gray-300">
                      {{ $sub->field($field['name']) }}
                    </td>
                  @endforeach
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Review Forms -->
          <div id="review-{{ $sub->id }}" class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <!-- Approve -->
            <div class="bg-emerald-50 dark:bg-emerald-900/10
                        border border-emerald-200 dark:border-emerald-900/40
                        rounded-lg p-4">
              <p class="text-xs font-medium text-emerald-600 dark:text-emerald-400 mb-3">
                Approve Entry
              </p>
              <form method="POST" action="{{ route('submissions.approve', $sub) }}"
                    class="space-y-3">
                @csrf
                @foreach($reviewFields as $field)
                <div>
                  <label class="block text-xs mb-1 text-gray-500 dark:text-gray-500">
                    {{ $field['label'] }}
                    @if($field['required'])<span class="text-rose-500">*</span>@endif
                  </label>
                  @if(!empty($field['auto_user']))
  {{-- Auto-filled with logged in username, readonly --}}
  <input type="text"
         name="{{ $field['name'] }}"
         value="{{ auth()->user()->name }}"
         readonly
         class="w-full rounded-lg px-3 py-2 text-xs focus:outline-none
                bg-gray-100 dark:bg-gray-800
                border border-gray-200 dark:border-gray-700
                text-gray-500 dark:text-gray-500
                cursor-not-allowed"/>

@elseif($field['type'] === 'date')
  <input type="date"
         name="{{ $field['name'] }}"
         value="{{ date('Y-m-d') }}"
         {{ $field['required'] ? 'required' : '' }}
         class="w-full rounded-lg px-3 py-2 text-xs focus:outline-none
                focus:ring-1 focus:ring-emerald-500
                bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                text-gray-800 dark:text-gray-200"/>

@elseif($field['type'] === 'time')
  <input type="time"
         name="{{ $field['name'] }}"
         value="{{ date('H:i') }}"
         {{ $field['required'] ? 'required' : '' }}
         class="w-full rounded-lg px-3 py-2 text-xs focus:outline-none
                focus:ring-1 focus:ring-emerald-500
                bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                text-gray-800 dark:text-gray-200"/>

@elseif($field['type'] === 'number')
  <input type="number"
         name="{{ $field['name'] }}"
         step="0.01"
         {{ $field['required'] ? 'required' : '' }}
         class="w-full rounded-lg px-3 py-2 text-xs focus:outline-none
                focus:ring-1 focus:ring-emerald-500
                bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                text-gray-800 dark:text-gray-200"/>

@else
  <input type="text"
         name="{{ $field['name'] }}"
         {{ $field['required'] ? 'required' : '' }}
         class="w-full rounded-lg px-3 py-2 text-xs focus:outline-none
                focus:ring-1 focus:ring-emerald-500
                bg-white dark:bg-gray-900
                border border-gray-200 dark:border-gray-700
                text-gray-800 dark:text-gray-200"/>
@endif
                </div>
                @endforeach
                <div>
                  <label class="block text-xs mb-1 text-gray-500 dark:text-gray-500">
                    Note (optional)
                  </label>
                  <textarea name="review_note" rows="2"
                            class="w-full rounded-lg px-3 py-2 text-xs resize-none
                                   focus:outline-none focus:ring-1 focus:ring-emerald-500
                                   bg-white dark:bg-gray-900
                                   border border-gray-200 dark:border-gray-700
                                   text-gray-800 dark:text-gray-200"
                            placeholder="Approval note..."></textarea>
                </div>
                <button type="submit"
                        class="w-full bg-emerald-600 hover:bg-emerald-500 text-white
                               text-xs font-medium py-2 rounded-lg transition-colors">
                  Approve
                </button>
              </form>
            </div>

            <!-- Reject -->
            <div class="bg-rose-50 dark:bg-rose-900/10
                        border border-rose-200 dark:border-rose-900/40
                        rounded-lg p-4">
              <p class="text-xs font-medium text-rose-600 dark:text-rose-400 mb-3">
                Reject Entry
              </p>
              <form method="POST" action="{{ route('submissions.reject', $sub) }}"
                    class="space-y-3">
                @csrf
                <div>
                  <label class="block text-xs mb-1 text-gray-500 dark:text-gray-500">
                    Reason <span class="text-rose-500">*</span>
                  </label>
                  <textarea name="review_note" rows="5" required
                            class="w-full rounded-lg px-3 py-2 text-xs resize-none
                                   focus:outline-none focus:ring-1 focus:ring-rose-500
                                   bg-white dark:bg-gray-900
                                   border border-gray-200 dark:border-gray-700
                                   text-gray-800 dark:text-gray-200"
                            placeholder="Explain why this entry is being rejected..."></textarea>
                </div>
                <button type="submit"
                        class="w-full bg-rose-600 hover:bg-rose-500 text-white
                               text-xs font-medium py-2 rounded-lg transition-colors">
                  Reject
                </button>
              </form>
            </div>

            <!-- Request Edit -->
            <div class="lg:col-span-2
                        bg-amber-50 dark:bg-amber-900/10
                        border border-amber-200 dark:border-amber-900/40
                        rounded-lg p-4">
              <p class="text-xs font-medium text-amber-600 dark:text-amber-400 mb-3">
                Request Edit from User
              </p>
              <form method="POST" action="{{ route('submissions.request-edit', $sub) }}"
                    class="flex gap-2">
                @csrf
                <input type="text" name="review_note" required
                       class="flex-1 rounded-lg px-3 py-2 text-xs focus:outline-none
                              focus:ring-1 focus:ring-amber-500
                              bg-white dark:bg-gray-900
                              border border-gray-200 dark:border-gray-700
                              text-gray-800 dark:text-gray-200"
                       placeholder="Tell the user what needs to be changed..."/>
                <button type="submit"
                        class="flex-shrink-0 bg-amber-500 hover:bg-amber-400 text-white
                               text-xs font-medium px-4 py-2 rounded-lg transition-colors">
                  Send Request
                </button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
  @empty
  <div class="px-5 py-12 text-center text-sm text-gray-400 dark:text-gray-600">
    No pending entries to review.
  </div>
  @endforelse

  <!-- Pagination Controls -->
  @if($pending->count() > 0)
  <div class="flex items-center justify-between px-5 py-3
              border-t border-gray-200 dark:border-gray-800">
    <p class="text-xs text-gray-400 dark:text-gray-600">
      Showing <span x-text="startItem"></span>–<span x-text="endItem"></span>
      of {{ $pending->count() }}
    </p>
    <div class="flex items-center gap-1">
      <button @click="prevPage()"
              :disabled="currentPage === 1"
              :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
              class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200
                     dark:border-gray-700 text-gray-600 dark:text-gray-400 transition-colors">
        ← Prev
      </button>
      <span class="text-xs text-gray-500 dark:text-gray-500 px-2">
        <span x-text="currentPage"></span> / <span x-text="totalPages"></span>
      </span>
      <button @click="nextPage()"
              :disabled="currentPage === totalPages"
              :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
              class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200
                     dark:border-gray-700 text-gray-600 dark:text-gray-400 transition-colors">
        Next →
      </button>
    </div>
  </div>
  @endif

</div>

<!-- Recently Approved -->

  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden mb-4"
       x-data="paginatedSection('approved', {{ $approved->count() }}, 5)">

    <div class="flex items-center justify-between px-5 py-4
                border-b border-gray-200 dark:border-gray-800">
      <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">
        Recently Approved
      </h3>
      <div class="flex items-center gap-1.5">
        <label class="text-xs text-gray-400 dark:text-gray-600">Show</label>
        <select x-model.number="perPage" @change="currentPage = 1"
                -class="text-xs bg-gray-50 dark:bg-gray-950 border border-gray-200
       dark:border-gray-800 rounded px-2 py-1
       text-gray-700 dark:text-gray-300 focus:outline-none appearance-none">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
        </select>
      </div>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($approved as $index => $sub)
      @php $config = $sub->registerConfig(); $fields = $config['fields'] ?? []; @endphp
      <div x-show="isVisible({{ $index }})"
           x-data="{ open: false }">

        <!-- Header row -->
        <div class="px-5 py-3 flex items-center gap-2">
          <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 flex-shrink-0"></div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
              {{ $sub->registerName() }}
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-600">
              {{ $sub->user->name }}
            </p>
          </div>
          <span class="text-xs text-gray-400 dark:text-gray-700 flex-shrink-0">
            {{ $sub->reviewed_at?->diffForHumans() }}
          </span>
          <button @click="open = !open"
                  class="flex items-center gap-1 text-xs px-2.5 py-1 rounded-lg
                         transition-colors flex-shrink-0
                         bg-gray-100 dark:bg-gray-800
                         text-gray-500 dark:text-gray-400
                         hover:bg-gray-200 dark:hover:bg-gray-700
                         border border-gray-200 dark:border-gray-700">
            <span x-text="open ? 'Hide' : 'View'"></span>
            <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180':''"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
        </div>

        <!-- Collapsible detail -->
        <div x-show="open" x-transition class="px-5 pb-4">
          <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-gray-800">
            <table class="w-full text-xs">
              <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                  @foreach($fields as $field)
                    <th class="text-left px-3 py-2 text-gray-500 dark:text-gray-500
                               font-medium whitespace-nowrap">
                      {{ $field['label'] }}
                    </th>
                  @endforeach
                  @foreach($config['review_fields'] ?? [] as $rf)
                    <th class="text-left px-3 py-2 font-medium whitespace-nowrap
                               text-emerald-600 dark:text-emerald-700">
                      {{ $rf['label'] }}
                    </th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                <tr class="bg-white dark:bg-gray-900">
                  @foreach($fields as $field)
                    <td class="px-3 py-2.5 whitespace-nowrap
                               text-gray-700 dark:text-gray-300">
                      {{ $sub->field($field['name']) }}
                    </td>
                  @endforeach
                  @foreach($config['review_fields'] ?? [] as $rf)
                    <td class="px-3 py-2.5 whitespace-nowrap
                               text-emerald-600 dark:text-emerald-400">
                      {{ $sub->reviewField($rf['name']) }}
                    </td>
                  @endforeach
                </tr>
              </tbody>
            </table>
          </div>
          @if($sub->review_note)
          <p class="text-xs text-emerald-600 dark:text-emerald-500 mt-2">
            Note: {{ $sub->review_note }}
          </p>
          @endif
        </div>

      </div>
      @empty
      <div class="px-5 py-6 text-center text-xs text-gray-400 dark:text-gray-700">
        None yet
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($approved->count() > 0)
    <div class="flex items-center justify-between px-5 py-3
                border-t border-gray-200 dark:border-gray-800">
      <p class="text-xs text-gray-400 dark:text-gray-600">
        <span x-text="startItem"></span>–<span x-text="endItem"></span>
        of {{ $approved->count() }}
      </p>
      <div class="flex items-center gap-1">
        <button @click="prevPage()" :disabled="currentPage === 1"
                :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
                class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200
                       dark:border-gray-700 text-gray-600 dark:text-gray-400">← Prev</button>
        <span class="text-xs text-gray-500 px-2">
          <span x-text="currentPage"></span>/<span x-text="totalPages"></span>
        </span>
        <button @click="nextPage()" :disabled="currentPage === totalPages"
                :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
                class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200
                       dark:border-gray-700 text-gray-600 dark:text-gray-400">Next →</button>
      </div>
    </div>
    @endif

  </div>

  <!-- Recently Rejected -->
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden mb-4"
       x-data="paginatedSection('rejected', {{ $rejected->count() }}, 5)">

    <div class="flex items-center justify-between px-5 py-4
                border-b border-gray-200 dark:border-gray-800">
      <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">
        Recently Rejected
      </h3>
      <div class="flex items-center gap-1.5">
        <label class="text-xs text-gray-400 dark:text-gray-600">Show</label>
        <select x-model.number="perPage" @change="currentPage = 1"
                -class="text-xs bg-gray-50 dark:bg-gray-950 border border-gray-200
       dark:border-gray-800 rounded px-2 py-1
       text-gray-700 dark:text-gray-300 focus:outline-none appearance-none">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="20">20</option>
        </select>
      </div>
    </div>

    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($rejected as $index => $sub)
      @php $config = $sub->registerConfig(); $fields = $config['fields'] ?? []; @endphp
      <div x-show="isVisible({{ $index }})"
           x-data="{ open: false }">

        <!-- Header row -->
        <div class="px-5 py-3 flex items-center gap-2">
          <div class="w-1.5 h-1.5 rounded-full bg-rose-500 flex-shrink-0"></div>
          <div class="flex-1 min-w-0">
            <p class="text-xs font-medium text-gray-700 dark:text-gray-300">
              {{ $sub->registerName() }}
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-600">
              {{ $sub->user->name }}
            </p>
          </div>
          <span class="text-xs text-gray-400 dark:text-gray-700 flex-shrink-0">
            {{ $sub->reviewed_at?->diffForHumans() }}
          </span>
          <button @click="open = !open"
                  class="flex items-center gap-1 text-xs px-2.5 py-1 rounded-lg
                         transition-colors flex-shrink-0
                         bg-gray-100 dark:bg-gray-800
                         text-gray-500 dark:text-gray-400
                         hover:bg-gray-200 dark:hover:bg-gray-700
                         border border-gray-200 dark:border-gray-700">
            <span x-text="open ? 'Hide' : 'View'"></span>
            <svg class="w-3 h-3 transition-transform" :class="open ? 'rotate-180':''"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 9l-7 7-7-7"/>
            </svg>
          </button>
        </div>

        <!-- Collapsible detail -->
        <div x-show="open" x-transition class="px-5 pb-4">
          <div class="overflow-x-auto rounded-lg border border-gray-100 dark:border-gray-800">
            <table class="w-full text-xs">
              <thead class="bg-gray-50 dark:bg-gray-800">
                <tr>
                  @foreach($fields as $field)
                    <th class="text-left px-3 py-2 text-gray-500 dark:text-gray-500
                               font-medium whitespace-nowrap">
                      {{ $field['label'] }}
                    </th>
                  @endforeach
                </tr>
              </thead>
              <tbody>
                <tr class="bg-white dark:bg-gray-900">
                  @foreach($fields as $field)
                    <td class="px-3 py-2.5 whitespace-nowrap
                               text-gray-700 dark:text-gray-300">
                      {{ $sub->field($field['name']) }}
                    </td>
                  @endforeach
                </tr>
              </tbody>
            </table>
          </div>
          @if($sub->review_note)
          <p class="text-xs text-rose-500 dark:text-rose-400 mt-2">
            Reason: {{ $sub->review_note }}
          </p>
          @endif
        </div>

      </div>
      @empty
      <div class="px-5 py-6 text-center text-xs text-gray-400 dark:text-gray-700">
        None yet
      </div>
      @endforelse
    </div>

    <!-- Pagination -->
    @if($rejected->count() > 0)
    <div class="flex items-center justify-between px-5 py-3
                border-t border-gray-200 dark:border-gray-800">
      <p class="text-xs text-gray-400 dark:text-gray-600">
        <span x-text="startItem"></span>–<span x-text="endItem"></span>
        of {{ $rejected->count() }}
      </p>
      <div class="flex items-center gap-1">
        <button @click="prevPage()" :disabled="currentPage === 1"
                :class="currentPage === 1 ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
                class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200
                       dark:border-gray-700 text-gray-600 dark:text-gray-400">← Prev</button>
        <span class="text-xs text-gray-500 px-2">
          <span x-text="currentPage"></span>/<span x-text="totalPages"></span>
        </span>
        <button @click="nextPage()" :disabled="currentPage === totalPages"
                :class="currentPage === totalPages ? 'opacity-40 cursor-not-allowed' : 'hover:bg-gray-100 dark:hover:bg-gray-800'"
                class="px-2.5 py-1.5 text-xs rounded-lg border border-gray-200
                       dark:border-gray-700 text-gray-600 dark:text-gray-400">Next →</button>
      </div>
    </div>
    @endif

  </div>



@push('scripts')
<script>
function paginatedSection(name, total, defaultPerPage) {
  return {
    currentPage: 1,
    perPage: defaultPerPage,
    total: total,

    get totalPages() {
      return Math.max(1, Math.ceil(this.total / this.perPage));
    },

    get startItem() {
      return Math.min((this.currentPage - 1) * this.perPage + 1, this.total);
    },

    get endItem() {
      return Math.min(this.currentPage * this.perPage, this.total);
    },

    isVisible(index) {
      const start = (this.currentPage - 1) * this.perPage;
      const end   = this.currentPage * this.perPage;
      return index >= start && index < end;
    },

    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    },

    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    }
  };
}
</script>
@endpush

@endsection