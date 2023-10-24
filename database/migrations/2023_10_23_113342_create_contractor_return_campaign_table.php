<?php

use B2BPanel\SharedModels\Contractor;
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
        Schema::create('contractor_return_campaign', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contractor::class)->constrained('contractors', 'logo')->cascadeOnDelete();
            $table->foreignIdFor(ReturnCampaign::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_return_campaign');
    }
};
