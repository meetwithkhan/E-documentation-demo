@extends('layouts.app')
@section('title', 'New Submission')
@section('page-title', 'New Submission')

@section('content')

<div class="max-w-5xl mx-auto">

  <!-- Header -->
  <div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
      Choose Submission Type
    </h2>

    <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
      Select the type of submission you want to create.
    </p>
  </div>

  <!-- Action Buttons -->
  <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

    <!-- Logbook Entry -->
    <a href="{{ route('submissions.create') }}"
       class="flex items-center gap-4 bg-white dark:bg-gray-900
              border border-gray-200 dark:border-gray-800
              rounded-xl p-5 hover:border-indigo-300
              dark:hover:border-indigo-700 hover:shadow-sm
              transition-all group">

      <div class="w-11 h-11 rounded-xl bg-indigo-600
                  flex items-center justify-center flex-shrink-0">

        <svg class="w-5 h-5 text-white"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>
        </svg>
      </div>

      <div>
        <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                  group-hover:text-indigo-600 dark:group-hover:text-indigo-400
                  transition-colors">
          Logbook Entry
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Submit a standard logbook entry
        </p>
      </div>
    </a>

    <!-- Analytical Report -->
    <a href="{{ route('submissions.analytical-report.type') }}"
       class="flex items-center gap-4 bg-white dark:bg-gray-900
              border border-gray-200 dark:border-gray-800
              rounded-xl p-5 hover:border-teal-300
              dark:hover:border-teal-700 hover:shadow-sm
              transition-all group">

      <div class="w-11 h-11 rounded-xl bg-teal-600
                  flex items-center justify-center flex-shrink-0">

        <svg class="w-5 h-5 text-white"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 17v-6m4 6V7m4 10v-3M5 21h14"/>
        </svg>
      </div>

      <div>
        <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                  group-hover:text-teal-600 dark:group-hover:text-teal-400
                  transition-colors">
          Analytical Report
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Create and submit analytical reports
        </p>
      </div>
    </a>

  </div>

</div>

@endsection