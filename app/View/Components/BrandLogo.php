<?php

namespace App\View\Components;

use App\Helpers\Brand;
use Closure;
use Illuminate\View\Component;

class BrandLogo extends Component
{
    public string $name;
    public string $logoType;
    public ?string $logoImage;
    public string $size;

    public function __construct(string $size = 'md')
    {
        $this->name      = Brand::name();
        $this->logoType  = Brand::get('logo_type', 'icon');
        $this->logoImage = Brand::get('logo_image');
        $this->size      = $size;
    }

    public function render(): \Illuminate\View\View
    {
        return view('components.brand-logo');
    }
}