<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('password');
            $table->string('telegram_id')->nullable()->unique()->after('role');
            $table->string('telegram_username')->nullable()->after('telegram_id');
            $table->boolean('is_active')->default(true)->after('telegram_username');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'telegram_id', 'telegram_username', 'is_active']);
        });
    }
};
