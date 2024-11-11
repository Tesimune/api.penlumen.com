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
        Schema::create('plagiarisms', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('score');
            $table->string('title');
            $table->longText('content')->nullable();
            $table->longText('sources')->nullable();
            $table->longText('citation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plagiarisms');
    }
};
