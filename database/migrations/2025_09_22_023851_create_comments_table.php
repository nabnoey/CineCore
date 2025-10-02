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
        // It's used to mark the existing 'comments' table as "created" in the migrations table,
        // resolving the "table already exists" error without dropping the table.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};