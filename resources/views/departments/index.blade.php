@extends('layouts.app')
@section('title', 'Departments')
@section('page-title', 'Departments & Functions')

@section('content')
@include('layouts.partials.alert')

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
  <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">All Departments</h3>
    <a href="{{ route('departments.create') }}"
       class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500
              text-white text-xs font-medium px-3 py-2 rounded-lg transition-colors">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Add Department
    </a>
  </div>

  <div class="divide-y divide-gray-100 dark:divide-gray-800">
    @forelse($departments as $dept)
    <div class="px-5 py-4 flex items-start justify-between gap-4">
      <div class="flex-1">
        <p class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-2">
          {{ $dept->name }}
          <span class="text-xs text-gray-400 dark:text-gray-600 font-normal ml-2">
            {{ $dept->users_count }} {{ Str::plural('user', $dept->users_count) }}
          </span>
        </p>
        <div class="flex flex-wrap gap-1.5">
          @foreach($dept->functions as $func)
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                         bg-indigo-50 dark:bg-indigo-900/30
                         text-indigo-600 dark:text-indigo-400
                         border border-indigo-200 dark:border-indigo-800">
              {{ $func->name }}
            </span>
          @endforeach
        </div>
      </div>
      <div class="flex items-center gap-3 flex-shrink-0">
        <a href="{{ route('departments.edit', $dept) }}"
           class="text-xs text-indigo-600 dark:text-indigo-400
                  hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
          Edit
        </a>
        <form method="POST" action="{{ route('departments.destroy', $dept) }}"
              onsubmit="return confirm('Delete this department?')">
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
      No departments found.
    </div>
    @endforelse
  </div>
</div>
@endsection