<?php

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
        Schema::table('returnms', function (Blueprint $table) {
            $table->foreignIdFor(ReturnCampaign::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('returnms', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(ReturnCampaign::class);
        });
    }
};
