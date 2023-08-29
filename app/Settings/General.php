<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class General extends Settings
{

    public bool $are_returnable_products_returnable;

    public static function group(): string
    {
        return 'general';
    }
}
