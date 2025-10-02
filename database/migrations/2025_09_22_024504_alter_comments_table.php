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
        // This migration is intentionally left blank.
        // Its original content was faulty (Schema::create on an existing table).
        // We are marking it as "run" to proceed with subsequent migrations.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};