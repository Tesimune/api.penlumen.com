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
        Schema::create('socialites', function (Blueprint $table) {
            $table->id();
            $table->string("uuid")->unique();
            $table->string("user_uuid");
            $table->string("socialite");
            $table->string("email");
            $table->string("token");
            $table->text("auth_data");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socialites');
    }
};
