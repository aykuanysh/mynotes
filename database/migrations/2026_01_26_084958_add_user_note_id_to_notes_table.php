<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Добавляем поле user_note_id - номер заметки у конкретного пользователя
     */
    public function up(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            // Добавляем после id
            $table->unsignedInteger('user_note_id')->after('id');
        });
    }

    /**
     * Откат миграции
     */
    public function down(): void
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropColumn('user_note_id');
        });
    }
};