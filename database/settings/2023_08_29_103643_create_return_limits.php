<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('limits.zabawki', 0.2);
        $this->migrator->add('limits.jezykowe', 0.15);
        $this->migrator->add('limits.jezykowe_oxford', 0.2);
        $this->migrator->add('limits.edukacyjne', 0.3);
        $this->migrator->add('limits.pozostale', 100.0);
    }
};
