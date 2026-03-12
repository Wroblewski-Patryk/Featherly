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
        Schema::table('templates', function (Blueprint $table) {
            $table->renameColumn('name', 'title');
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->json('title')->change();
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->json('title')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->string('title')->change();
        });

        Schema::table('templates', function (Blueprint $table) {
            $table->string('title')->change();
            $table->renameColumn('title', 'name');
        });
    }
};
