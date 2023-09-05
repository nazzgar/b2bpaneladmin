<?php

use B2BPanel\SharedModels\CustomerUser;
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
        Schema::create('returnms', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CustomerUser::class);
            //status = draft | send | accepted
            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returnms');
    }
};
