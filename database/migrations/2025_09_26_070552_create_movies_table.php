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
        // Intentionally blank. The 'movies' table was created by an earlier, now-deleted migration.
        // This file is kept for migration history consistency.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('movies'); // It's safer to not drop the table on rollback
    }
};