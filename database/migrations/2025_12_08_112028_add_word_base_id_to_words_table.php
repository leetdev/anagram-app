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
        Schema::table('words', function (Blueprint $table) {
            $table->foreignId('word_base_id')
                ->constrained('word_bases')
                ->cascadeOnDelete();

            $table->unique(['word', 'word_base_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('words', function (Blueprint $table) {
            $table->dropUnique(['word', 'word_base_id']);
            $table->dropForeign(['word_base_id']);
            $table->dropColumn('word_base_id');
        });
    }
};
