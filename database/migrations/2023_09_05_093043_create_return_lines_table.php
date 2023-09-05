<?php

use B2BPanel\SharedModels\Returnm;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('return_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Returnm::class);
            $table->string('symkar', 20);
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_lines');
    }
};
