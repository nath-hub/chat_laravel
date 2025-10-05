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
           $table->char('id', 36)->primary();
            $table->string('username')->nullable();
            $table->string('otp', 6)->nullable();
            $table->dateTime('otp_expiry')->nullable();
            $table->boolean('is_active')->default(0);
            $table->string('email');
            $table->string('google_id')->nullable();
            $table->enum('theme', ['light', 'dark'])->default('light');
            $table->integer('font_size')->default(14);
            $table->string('language', 10)->default('en');
            $table->boolean('animation')->default(1);
            $table->string('avatar')->default('https://cdn-icons-png.flaticon.com/512/149/149071.png');
            $table->text('biographie')->nullable();
            $table->enum('type_abonnement', ['free', 'premium'])->default('free');
            $table->boolean('subscriber')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->date('last_connection_date')->nullable();
            $table->timestamps(0);
        });

       

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
