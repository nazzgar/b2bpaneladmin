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
        Schema::create('bez_prawa_zwrotu_products', function (Blueprint $table) {
            $table->string('symkar', 20)->index();
            $table->string('kodkres', 50);
            $table->string('opis', 200);
            $table->boolean('isZwrotne')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bez_prawa_zwrotu_products');
    }
};
