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
        Schema::create('lins', function (Blueprint $table) {
<<<<<<< HEAD
            $table->bigInteger('id', true, false);
=======
            $table->id();
>>>>>>> 322e07c (fix id column in migration)
            $table->integer('nagid');
            $table->foreign('nagid')->references('nagid')->on('nags');
            $table->integer('lp');
            $table->string('kodkres', 50);
            $table->string('symkar', 20);
            $table->integer('ilosc');
            $table->string('JM', 6);
            $table->float('stawka', 5, 3);
            $table->integer('cena_netto');
            $table->integer('cena_netto_po_rabacie');
            $table->integer('cena_brutto');
            $table->integer('cena_brutto_po_rabacie');
            $table->string('opis', 200)->nullable();
            $table->integer('netto_suma');
            $table->integer('brutto_suma');
            $table->integer('vat_suma');
            $table->string('PD_Wydawnictwo', 255);
            $table->foreign('PD_Wydawnictwo')->references('grupa')->on('publishers');
            $table->string('PD_typoferty', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
            $table->unique(['nagid', 'lp']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lins');
    }
};
