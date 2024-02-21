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
        Schema::dropIfExists('gpt_models');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('gpt_models', function (Blueprint $table) {
            $table->id();
            $table->string("code")->index();
        });
    }
};