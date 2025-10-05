<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->char('conversation_id', 36);
            $table->char('user_id', 36)->nullable();
            $table->enum('role', ['system', 'user', 'assistant']);
            $table->text('message');
            $table->longText('metadata')->nullable()->check('json_valid(`metadata`)');
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
