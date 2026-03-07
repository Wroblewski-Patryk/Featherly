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
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->boolean('is_published')->default(false);
        });
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_published')->default(false);
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->boolean('is_published')->default(false);
        });
        Schema::table('forms', function (Blueprint $table) {
            $table->boolean('is_published')->default(false);
        });
    }
};
