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
        // Adds the 'role' column to the existing 'users' table
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('staff')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Removes the 'role' column for rollback capability
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};