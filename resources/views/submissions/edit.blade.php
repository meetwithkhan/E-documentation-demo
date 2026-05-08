@extends('layouts.app')
@section('title', 'Edit Entry')
@section('page-title', 'Edit Logbook Entry')

@section('content')
<div class="max-w-3xl">

  <!-- Manager Note -->
  <div class="bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-800
              rounded-xl p-4 mb-5">
    <p class="text-xs font-medium text-amber-700 dark:text-amber-400 mb-1">
      Manager requested changes:
    </p>
    <p class="text-sm text-amber-800 dark:text-amber-300">{{ $submission->review_note }}</p>
  </div>

  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">
      {{ $submission->registerName() }}
    </h3>

    @php
      $fields = config("registers.{$submission->register_type}.fields", []);
      $widthClass = ['sm' => 'col-span-1', 'md' => 'col-span-1 sm:col-span-2', 'full' => 'col-span-1 sm:col-span-3'];
    @endphp

    <form method="POST" action="{{ route('submissions.update', $submission) }}" class="space-y-4">
      @csrf @method('PATCH')

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach($fields as $field)
        <div class="{{ $widthClass[$field['width']] ?? 'col-span-1' }}">
          <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
            {{ $field['label'] }}
            @if($field['required'])<span class="text-rose-500">*</span>@endif
          </label>

          @if($field['name'] === 'remarks')
            {{-- Remarks is locked --}}
            <input type="text" disabled
                   value="{{ $submission->field('remarks') }}"
                   class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200
                          dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm
                          text-gray-400 dark:text-gray-600 cursor-not-allowed"/>
            <p class="text-xs text-amber-600 dark:text-amber-700 mt-1">
              Remarks are locked after edit request
            </p>

          @elseif($field['type'] === 'text')
              @if(!empty($field['auto_user']))
                {{-- Auto-filled with logged in username, readonly --}}
                <input type="text"
                      name="{{ $field['name'] }}" 
                      value="{{ auth()->user()->name }}"
                      readonly
                      class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200
                              dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm
                              text-gray-400 dark:text-gray-500 cursor-not-allowed
                              focus:outline-none"/>
              @elseif(!empty($field['auto_sr']))
                {{-- Auto-filled with next Sr. No., readonly --}}
                <input type="text"
                      name="{{ $field['name'] }}" 
                      value="{{ $submission->field($field['name']) }}"
                      readonly
                      class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200
                              dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm
                              text-gray-400 dark:text-gray-500 cursor-not-allowed
                              focus:outline-none"/>
              @else
                <input type="text"
                      name="{{ $field['name'] }}"
                      value="{{ old($field['name'], $submission->field($field['name'])) }}"
                      {{ $field['required'] ? 'required' : '' }}
                      class="w-full bg-white dark:bg-gray-900 border border-gray-200
                              dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                              text-gray-500 focus:outline-none focus:ring-1
                              focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="{{ $field['label'] }}"/>
              @endif
          @elseif($field['type'] === 'number')
            <input type="number" name="{{ $field['name'] }}" step="0.01"
                   value="{{ old($field['name'], $submission->field($field['name'])) }}"
                   {{ $field['required'] ? 'required' : '' }}
                   class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                          dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                          text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-1
                          focus:ring-indigo-500 focus:border-indigo-500"/>

          @elseif($field['type'] === 'date')
            <input type="date" name="{{ $field['name'] }}"
                   value="{{ old($field['name'], $submission->field($field['name'])) }}"
                   {{ $field['required'] ? 'required' : '' }}
                   class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                          dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                          text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-1
                          focus:ring-indigo-500 focus:border-indigo-500"/>


          @elseif($field['type'] === 'product_select')
            <select name="{{ $field['name'] }}"
                    {{ $field['required'] ? 'required' : '' }}
                    class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                          dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                          text-gray-900 dark:text-gray-200 focus:outline-none
                          focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500
                          appearance-none">
              <option value="">Select Product</option>
              @foreach(config('products.items') as $product)
                <option value="{{ $product }}"
                        {{ $submission->field($field['name']) === $product ? 'selected' : '' }}>
                  {{ $product }}
                </option>
              @endforeach
            </select>

          @elseif($field['type'] === 'time')
            <input type="time" name="{{ $field['name'] }}"
                   value="{{ old($field['name'], $submission->field($field['name'])) }}"
                   {{ $field['required'] ? 'required' : '' }}
                   class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                          dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                          text-gray-900 dark:text-gray-200 focus:outline-none focus:ring-1
                          focus:ring-indigo-500 focus:border-indigo-500"/>
          @endif

          @error($field['name'])
            <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
          @enderror
        </div>
        @endforeach
      </div>

      <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-800">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                       font-medium px-5 py-2.5 rounded-lg transition-colors">
          Resubmit Entry
        </button>
        <a href="{{ route('submissions.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection