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
        Schema::create('contractor_customer_user', function (Blueprint $table) {
            $table->string('logo');
            $table->bigIncrements('customer_user_id');
            $table->foreign('logo')->references('logo')->on('contractors');
            $table->foreign('customer_user_id')->references('id')->on('customer_users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_customer_user');
    }
};
