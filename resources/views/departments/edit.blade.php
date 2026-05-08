@extends('layouts.app')
@section('title', 'Edit Department')
@section('page-title', 'Edit Department')

@section('content')
<div class="max-w-lg">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">
      Edit — {{ $department->name }}
    </h3>

    <form method="POST" action="{{ route('departments.update', $department) }}" class="space-y-4"
          x-data="{ functions: {{ json_encode($department->functions->pluck('name')->toArray()) }} }">
      @csrf @method('PATCH')

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Department Name</label>
        <input type="text" name="name" value="{{ old('name', $department->name) }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500"/>
        @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-2">Functions</label>
        <div class="space-y-2">
          <template x-for="(func, index) in functions" :key="index">
            <div class="flex items-center gap-2">
              <input type="text" :name="`functions[${index}]`" x-model="functions[index]"
                     required
                     class="flex-1 bg-gray-50 dark:bg-gray-950 border border-gray-200
                            dark:border-gray-800 rounded-lg px-3 py-2 text-sm
                            text-gray-900 dark:text-gray-200 focus:outline-none
                            focus:ring-1 focus:ring-indigo-500"/>
              <button type="button" @click="functions.splice(index, 1)"
                      x-show="functions.length > 1"
                      class="text-rose-500 hover:text-rose-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>
          </template>
        </div>
        <button type="button" @click="functions.push('')"
                class="mt-2 text-xs text-indigo-600 dark:text-indigo-400
                       hover:text-indigo-800 transition-colors flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"/>
          </svg>
          Add another function
        </button>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                       font-medium px-5 py-2.5 rounded-lg transition-colors">
          Save Changes
        </button>
        <a href="{{ route('departments.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300
                  transition-colors">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection