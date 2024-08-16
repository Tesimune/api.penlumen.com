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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('uuid')->unique();
            $table->string('isbn')->nullable();
            $table->foreignId('user_id')
                ->references("id")
                ->on("users")
                ->onDelete("cascade");
            $table->longText("content")->nullable();
            $table->string("description")->nullable();
            $table->string("cover")->nullable();
            $table->string("status")->nullable()->default(\App\Enums\BookStatus::DRAFT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
