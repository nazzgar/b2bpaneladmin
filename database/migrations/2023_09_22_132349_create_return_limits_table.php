<?php

use B2BPanel\SharedModels\CustomerUser;
use B2BPanel\SharedModels\ReturnCampaign;
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
        Schema::create('return_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CustomerUser::class);
            $table->foreignIdFor(ReturnCampaign::class);
            $table->text('limits');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_limits');
    }
};
