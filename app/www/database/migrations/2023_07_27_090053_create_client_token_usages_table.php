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
        Schema::create('client_token_usages', function (Blueprint $table) {
            $table->id();
            $table->string("client_license_hash")->index()->nullable();
            $table->integer('token_count_prompt')->index()->default(0);
            $table->integer("token_count_completion")->index()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_token_usages');
    }
};
