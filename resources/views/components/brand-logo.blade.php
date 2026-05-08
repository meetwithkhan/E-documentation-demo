@php
  use App\Helpers\Brand;
  $color = Brand::colorClasses();
  $sizes = [
    'sm' => ['wrap' => 'w-6 h-6', 'icon' => 'w-3 h-3', 'text' => 'text-xs'],
    'md' => ['wrap' => 'w-7 h-7', 'icon' => 'w-4 h-4', 'text' => 'text-sm'],
    'lg' => ['wrap' => 'w-10 h-10', 'icon' => 'w-5 h-5', 'text' => 'text-base'],
  ];
  $sz = $sizes[$size] ?? $sizes['md'];
@endphp

<div class="flex items-center gap-2">
  @if($logoType === 'image' && $logoImage)
    <img src="{{ asset($logoImage) }}" alt="{{ $name }}"
         class="{{ $sz['wrap'] }} object-contain rounded-lg"/>
  @elseif($logoType === 'text')
    <span class="{{ $color['bg'] }} {{ $sz['wrap'] }} rounded-lg flex items-center
                 justify-center text-white font-bold {{ $sz['text'] }}">
      {{ Brand::get('logo_initials', 'AB') }}
    </span>
  @else
    <div class="{{ $color['bg'] }} {{ $sz['wrap'] }} rounded-lg flex items-center
                justify-center flex-shrink-0">
      <svg class="{{ $sz['icon'] }} fill-white" viewBox="0 0 24 24">
        <path d="M13 3L4 14h7l-2 7 9-11h-7l2-7z"/>
      </svg>
    </div>
  @endif

   <span class="font-medium {{ $sz['text'] }} text-gray-900 dark:text-white">
    {{ $name }}
  </span>
</div>