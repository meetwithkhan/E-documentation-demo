@php $active = request()->routeIs($route . '*'); @endphp
<a href="{{ route($route) }}"
   class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm transition-colors
          {{ $active ? 'bg-gray-800 text-white' : 'text-gray-500 hover:bg-gray-800/50 hover:text-gray-300' }}">
  <span class="w-2 h-2 rounded-sm {{ $color }} flex-shrink-0"></span>
  {{ $label }}
</a>