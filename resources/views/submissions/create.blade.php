@extends('layouts.app')
@section('title', 'New Entry')
@section('page-title', 'New Logbook Entry')

@section('content')

<!-- Pass config to JS -->
<script>
    window.registerData = @json(config('registers'));
</script>

<div class="max-w-3xl" x-data="registerSearch()" x-init="init()">

  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6">

    <!-- ========================= -->
    <!-- REGISTER SEARCH -->
    <!-- ========================= -->
    <div class="mb-6 relative">

      <label class="block text-xs text-gray-500 mb-2">
        Select Register Type <span class="text-rose-500">*</span>
      </label>

      <!-- hidden input -->
      <input type="hidden" name="register_type_picker" x-model="registerType">

      <!-- search input -->
      <input type="text"
             x-model="search"
             @input="filterRegisters()"
             @focus="open = true"
             @keydown.escape="open = false"
             placeholder="Search register..."
             class="w-full bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
                    rounded-lg px-3 py-2.5 text-sm focus:ring-1 focus:ring-indigo-500">

      <!-- dropdown -->
      <div x-show="open"
           x-transition
           @click.away="open = false"
           class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-900 border border-gray-200
                  dark:border-gray-800 rounded-lg shadow-lg max-h-60 overflow-y-auto">

        <template x-for="item in results" :key="item.key">
          <div @click="select(item)"
               class="px-3 py-2 text-sm cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
            <span x-text="item.name"></span>
          </div>
        </template>

        <div x-show="results.length === 0"
             class="px-3 py-2 text-xs text-gray-500">
          No results found
        </div>

      </div>
    </div>

    <!-- ========================= -->
    <!-- EMPTY STATE -->
    <!-- ========================= -->
    <div x-show="registerType === ''" class="text-center py-8">
      <p class="text-sm text-gray-600">
        Select a register type above to begin
      </p>
    </div>

    <!-- ========================= -->
    <!-- DYNAMIC FORMS -->
    <!-- ========================= -->
    @foreach($registers as $key => $register)
    <div x-show="registerType === '{{ $key }}'" x-transition>

      <div class="border-t border-gray-800 pt-5 mb-5">
        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Register</p>
        <p class="text-sm text-gray-500 font-medium">{{ $register['name'] }}</p>
        <p class="text-xs text-gray-600 mt-0.5">{{ config('brand.location') }}</p>
      </div>

      <form method="POST" action="{{ route('submissions.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="register_type" :value="registerType">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

          @php
            $nextSrNo = \App\Models\Submission::nextSrNo($key);
          @endphp

          <div class="mb-4 flex items-center gap-2">
            <span class="text-xs text-gray-500">Sr. No. :</span>
            <span class="text-xs font-mono font-bold px-2 py-1 rounded
                         bg-indigo-50 dark:bg-indigo-900/30
                         text-indigo-600 dark:text-indigo-400">
              #{{ $nextSrNo }}
            </span>
          </div>

          @foreach($register['fields'] as $field)
            @if(!empty($field['auto_sr'])) @continue @endif

            <div class="col-span-1">

              <label class="block text-xs text-gray-500 mb-1.5">
                {{ $field['label'] }}
                @if($field['required'])<span class="text-rose-500">*</span>@endif
              </label>

              @if($field['type'] === 'text')
                @if(!empty($field['auto_user']))
                  <input type="text"
                         name="{{ $field['name'] }}"
                         value="{{ auth()->user()->name }}"
                         readonly
                         class="w-full bg-gray-100 dark:bg-gray-800 border border-gray-200
                                dark:border-gray-700 rounded-lg px-3 py-2.5 text-sm">

                @else
                  <input type="text"
                         name="{{ $field['name'] }}"
                         value="{{ old($field['name']) }}"
                         class="w-full bg-white dark:bg-gray-900 border border-gray-200
                                dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm">
                @endif

              @elseif($field['type'] === 'number')
                <input type="number"
                       name="{{ $field['name'] }}"
                       value="{{ old($field['name']) }}"
                       step="0.01"
                       class="w-full bg-white dark:bg-gray-900 border border-gray-200
                              dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm">

              @elseif($field['type'] === 'date')
                <input type="date"
                       name="{{ $field['name'] }}"
                       value="{{ old($field['name'], date('Y-m-d')) }}"
                       class="w-full bg-white dark:bg-gray-900 border border-gray-200
                              dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm">

              @elseif($field['type'] === 'product_select')
                <select name="{{ $field['name'] }}"
                        class="w-full bg-white dark:bg-gray-900 border border-gray-200
                               dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm">

                  <option value="">Select Product</option>
                  @foreach(config('products.items') as $product)
                    <option value="{{ $product }}">{{ $product }}</option>
                  @endforeach

                </select>

              @elseif($field['type'] === 'time')
                <input type="time"
                       name="{{ $field['name'] }}"
                       value="{{ old($field['name'], date('H:i')) }}"
                       class="w-full bg-white dark:bg-gray-900 border border-gray-200
                              dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm">
              @endif

            </div>
          @endforeach

        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-800">
          <button type="submit"
                  class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                         font-medium px-5 py-2.5 rounded-lg">
            Submit Entry
          </button>

          <a href="{{ route('submissions.index') }}"
             class="text-sm text-gray-500 hover:text-gray-300">
            Cancel
          </a>
        </div>

      </form>
    </div>
    @endforeach

  </div>
</div>

<!-- ========================= -->
<!-- ALPINE LOGIC -->
<!-- ========================= -->
<script>
function registerSearch() {
    return {
        search: '',
        results: [],
        registerType: '',
        open: false,

        init() {
            this.results = Object.entries(window.registerData).map(([key, val]) => ({
                key: key,
                name: val.name
            }));
        },

        filterRegisters() {
            let q = this.search.toLowerCase();

            // ✅ IF EMPTY → SHOW FULL LIST + RESET FORM
            if (q.length === 0) {
                this.registerType = '';   // reset form
                this.open = true;         // keep dropdown open

                this.results = Object.entries(window.registerData).map(([key, val]) => ({
                    key: key,
                    name: val.name
                }));

                return;
            }

            // FILTER MODE
            this.results = Object.entries(window.registerData)
                .map(([key, val]) => ({
                    key: key,
                    name: val.name
                }))
                .filter(item => item.name.toLowerCase().includes(q));

            this.open = true;
        },

        select(item) {
            this.registerType = item.key;
            this.search = item.name;
            this.open = false;
        }
    }
}
</script>

@endsection