<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class ReturnLimits extends Settings
{

    public float $zabawki;

    public float $jezykowe;

    public float $jezykowe_oxford;

    public float $edukacyjne;

    public float $pozostale;


    public static function group(): string
    {
        return 'limits';
    }
}
