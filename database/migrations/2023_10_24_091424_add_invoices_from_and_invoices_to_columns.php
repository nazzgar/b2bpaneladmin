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
        Schema::table('return_campaigns', function (Blueprint $table) {
            $table->date('invoices_from');
            $table->date('invoices_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('return_campaigns', function (Blueprint $table) {
            $table->dropColumn('invoices_from');
            $table->dropColumn('invoices_to');
        });
    }
};
