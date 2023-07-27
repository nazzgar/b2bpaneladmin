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
        Schema::create('nags', function (Blueprint $table) {
            $table->integer('nagid')->unique();
            $table->string('rd', 8);
            $table->string('numer', 100);
            $table->string('numerdok', 100)->nullable();
            $table->string('opis', 255)->nullable();
            $table->string('logo');
            $table->string('logop');
            $table->foreign('logo')->references('logo')->on('contractors');
            $table->foreign('logop')->references('logo')->on('contractors');
            $table->date('data')->nullable();
            $table->date('datasprz')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nags');
    }
};
