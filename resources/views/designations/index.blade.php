@extends('layouts.app')
@section('title', 'Designations')
@section('page-title', 'Designations')

@section('content')
@include('layouts.partials.alert')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

  <!-- Add Form -->
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-5 h-fit">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4">
      Add Designation
    </h3>
    <form method="POST" action="{{ route('designations.store') }}" class="space-y-3">
      @csrf
      <div>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500"
               placeholder="e.g. Senior Executive"/>
        @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>
      <button type="submit"
              class="w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                     font-medium py-2.5 rounded-lg transition-colors">
        Add Designation
      </button>
    </form>
  </div>

  <!-- List -->
  <div class="lg:col-span-2 bg-white dark:bg-gray-900 border border-gray-200
              dark:border-gray-800 rounded-xl overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800">
      <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">
        All Designations
      </h3>
    </div>
    <div class="divide-y divide-gray-100 dark:divide-gray-800">
      @forelse($designations as $desig)
      <div class="px-5 py-3 flex items-center justify-between gap-4"
           x-data="{ editing: false }">
        <div class="flex-1">
          <span x-show="!editing"
                class="text-sm text-gray-700 dark:text-gray-300">
            {{ $desig->name }}
            <span class="text-xs text-gray-400 dark:text-gray-600 ml-2">
              {{ $desig->users_count }} {{ Str::plural('user', $desig->users_count) }}
            </span>
          </span>
          <form x-show="editing" method="POST"
                action="{{ route('designations.update', $desig) }}"
                class="flex items-center gap-2">
            @csrf @method('PATCH')
            <input type="text" name="name" value="{{ $desig->name }}"
                   class="flex-1 bg-gray-50 dark:bg-gray-950 border border-gray-200
                          dark:border-gray-800 rounded-lg px-3 py-1.5 text-sm
                          text-gray-900 dark:text-gray-200 focus:outline-none
                          focus:ring-1 focus:ring-indigo-500"/>
            <button type="submit"
                    class="text-xs bg-indigo-600 hover:bg-indigo-500 text-white
                           px-3 py-1.5 rounded-lg transition-colors">
              Save
            </button>
            <button type="button" @click="editing = false"
                    class="text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300
                           transition-colors">
              Cancel
            </button>
          </form>
        </div>
        <div x-show="!editing" class="flex items-center gap-3">
          <button @click="editing = true"
                  class="text-xs text-indigo-600 dark:text-indigo-400
                         hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
            Edit
          </button>
          <form method="POST" action="{{ route('designations.destroy', $desig) }}"
                onsubmit="return confirm('Delete this designation?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="text-xs text-rose-500 hover:text-rose-700 dark:hover:text-rose-400
                           transition-colors">
              Delete
            </button>
          </form>
        </div>
      </div>
      @empty
      <div class="px-5 py-10 text-center text-sm text-gray-400 dark:text-gray-600">
        No designations yet.
      </div>
      @endforelse
    </div>
  </div>

</div>
@endsection