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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string( column: 'name');
            $table->string(column: 'email')->unique();
            $table->timestamp( column: 'email_verified_at')->nullable();
            $table->string( column: 'password');
            $table->enum('level', ['superadmin', 'admin']);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens',callback: function (Blueprint $table) {
            $table->string(column: 'email')->primary();
            $table->string(column: 'token');
            $table->timestamp(column: 'created_at')->nullable();
        });

        Schema::create(table: 'sessions',callback: function (Blueprint $table) {
            $table->string(column: 'id')->primary();
            $table->foreignId(column: 'user_id')->nullable()->index();
            $table->string(column: 'ip_address', length:  45)->nullable();
            $table->text(column: 'user_agent')->nullable();
            $table->longText(column: 'payload');
            $table->integer(column: 'last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'users');
        Schema::dropIfExists(table: 'password_reset_tokens');
        Schema::dropIfExists(table: 'sessions');
    }
};
