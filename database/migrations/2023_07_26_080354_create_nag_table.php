<?php

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
        Schema::create('nag', function (Blueprint $table) {
            $table->integer('nagid')->unique();
            $table->string('rd', 8);
            $table->string('numer', 100);
            $table->string('numerdok', 100);
            $table->string('opis', 255)->nullable();
            $table->foreign('logo')->references('logo')->on('contractors');
            $table->foreign('logop')->references('logo')->on('contractors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nag');
    }
};
