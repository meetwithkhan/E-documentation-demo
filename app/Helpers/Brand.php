<?php

namespace App\Helpers;

class Brand
{
    public static function get(string $key, mixed $default = null): mixed
    {
        return config("brand.$key", $default);
    }

    public static function name(): string
    {
        return config('brand.name', 'AdminBase');
    }

    public static function color(): string
    {
        return config('brand.brand_color', 'indigo');
    }

    // Returns Tailwind classes for the brand color
    public static function colorClasses(): array
    {
        $color = self::color();

        $map = [
            'indigo'  => [
                'bg'          => 'bg-indigo-600',
                'bg_hover'    => 'hover:bg-indigo-500',
                'bg_light'    => 'bg-indigo-900/50',
                'text'        => 'text-indigo-400',
                'border'      => 'border-indigo-800',
                'ring'        => 'focus:ring-indigo-500',
                'active_bg'   => 'bg-gray-800',
                'active_text' => 'text-white',
            ],
            'blue' => [
                'bg'          => 'bg-blue-600',
                'bg_hover'    => 'hover:bg-blue-500',
                'bg_light'    => 'bg-blue-900/50',
                'text'        => 'text-blue-400',
                'border'      => 'border-blue-800',
                'ring'        => 'focus:ring-blue-500',
                'active_bg'   => 'bg-gray-800',
                'active_text' => 'text-white',
            ],
            'violet' => [
                'bg'          => 'bg-violet-600',
                'bg_hover'    => 'hover:bg-violet-500',
                'bg_light'    => 'bg-violet-900/50',
                'text'        => 'text-violet-400',
                'border'      => 'border-violet-800',
                'ring'        => 'focus:ring-violet-500',
                'active_bg'   => 'bg-gray-800',
                'active_text' => 'text-white',
            ],
            'emerald' => [
                'bg'          => 'bg-emerald-600',
                'bg_hover'    => 'hover:bg-emerald-500',
                'bg_light'    => 'bg-emerald-900/50',
                'text'        => 'text-emerald-400',
                'border'      => 'border-emerald-800',
                'ring'        => 'focus:ring-emerald-500',
                'active_bg'   => 'bg-gray-800',
                'active_text' => 'text-white',
            ],
            'rose' => [
                'bg'          => 'bg-rose-600',
                'bg_hover'    => 'hover:bg-rose-500',
                'bg_light'    => 'bg-rose-900/50',
                'text'        => 'text-rose-400',
                'border'      => 'border-rose-800',
                'ring'        => 'focus:ring-rose-500',
                'active_bg'   => 'bg-gray-800',
                'active_text' => 'text-white',
            ],
            'amber' => [
                'bg'          => 'bg-amber-600',
                'bg_hover'    => 'hover:bg-amber-500',
                'bg_light'    => 'bg-amber-900/50',
                'text'        => 'text-amber-400',
                'border'      => 'border-amber-800',
                'ring'        => 'focus:ring-amber-500',
                'active_bg'   => 'bg-gray-800',
                'active_text' => 'text-white',
            ],
            'teal' => [
                'bg'          => 'bg-teal-600',
                'bg_hover'    => 'hover:bg-teal-500',
                'bg_light'    => 'bg-teal-900/50',
                'text'        => 'text-teal-400',
                'border'      => 'border-teal-800',
                'ring'        => 'focus:ring-teal-500',
                'active_bg'   => 'bg-gray-800',
                'active_text' => 'text-white',
            ],
        ];

        return $map[$color] ?? $map['indigo'];
    }
}