@extends('layouts.app')
@section('title', 'Analytical Report')
@section('page-title', 'Analytical Report')

@section('content')

<div class="max-w-5xl mx-auto">

  <!-- Header -->
  <div class="mb-6">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
      Select Report Type
    </h2>

    <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">
      Choose the analytical report category you want to create.
    </p>
  </div>

  <!-- Report Buttons -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

    <!-- FG -->
    <a href="#"
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
          FG
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Finished goods analytical reports
        </p>
      </div>
    </a>

    <!-- RM -->
    <a href="#"
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
          RM
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Raw material analytical reports
        </p>
      </div>
    </a>

    <!-- Bulk -->
    <a href="#"
       class="flex items-center gap-4 bg-white dark:bg-gray-900
              border border-gray-200 dark:border-gray-800
              rounded-xl p-5 hover:border-blue-300
              dark:hover:border-blue-700 hover:shadow-sm
              transition-all group">

      <div class="w-11 h-11 rounded-xl bg-blue-600
                  flex items-center justify-center flex-shrink-0">

        <svg class="w-5 h-5 text-white"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v8m4-4H8"/>
        </svg>
      </div>

      <div>
        <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                  group-hover:text-blue-600 dark:group-hover:text-blue-400
                  transition-colors">
          Bulk
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Bulk product analytical reports
        </p>
      </div>
    </a>

    <!-- Retention FG -->
    <a href="#"
       class="flex items-center gap-4 bg-white dark:bg-gray-900
              border border-gray-200 dark:border-gray-800
              rounded-xl p-5 hover:border-amber-300
              dark:hover:border-amber-700 hover:shadow-sm
              transition-all group">

      <div class="w-11 h-11 rounded-xl bg-amber-600
                  flex items-center justify-center flex-shrink-0">

        <svg class="w-5 h-5 text-white"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v11a2 2 0 002 2z"/>
        </svg>
      </div>

      <div>
        <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                  group-hover:text-amber-600 dark:group-hover:text-amber-400
                  transition-colors">
          Retention FG
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Retention finished goods reports
        </p>
      </div>
    </a>

    <!-- Retest RM -->
    <a href="#"
       class="flex items-center gap-4 bg-white dark:bg-gray-900
              border border-gray-200 dark:border-gray-800
              rounded-xl p-5 hover:border-rose-300
              dark:hover:border-rose-700 hover:shadow-sm
              transition-all group">

      <div class="w-11 h-11 rounded-xl bg-rose-600
                  flex items-center justify-center flex-shrink-0">

        <svg class="w-5 h-5 text-white"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>

      <div>
        <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                  group-hover:text-rose-600 dark:group-hover:text-rose-400
                  transition-colors">
          Retest RM
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Retest raw material analytical reports
        </p>
      </div>
    </a>

    <!-- Water Report -->
    <a href="#"
       class="flex items-center gap-4 bg-white dark:bg-gray-900
              border border-gray-200 dark:border-gray-800
              rounded-xl p-5 hover:border-cyan-300
              dark:hover:border-cyan-700 hover:shadow-sm
              transition-all group">

      <div class="w-11 h-11 rounded-xl bg-cyan-600
                  flex items-center justify-center flex-shrink-0">

        <svg class="w-5 h-5 text-white"
             fill="none"
             stroke="currentColor"
             viewBox="0 0 24 24">

          <path stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 3s6 5.686 6 10a6 6 0 11-12 0c0-4.314 6-10 6-10z"/>
        </svg>
      </div>

      <div>
        <p class="text-sm font-medium text-gray-900 dark:text-gray-200
                  group-hover:text-cyan-600 dark:group-hover:text-cyan-400
                  transition-colors">
          Water Report
        </p>

        <p class="text-xs text-gray-500 dark:text-gray-600 mt-0.5">
          Water quality analytical reports
        </p>
      </div>
    </a>

  </div>

</div>

@endsection