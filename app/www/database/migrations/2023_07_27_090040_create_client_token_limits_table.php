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
        Schema::create('client_token_limits', function (Blueprint $table) {
            $table->id();
            $table->string("client_license_hash")->index()->nullable()->unique();
            $table->integer("limit")->index()->nullable();
            $table->integer("is_demo")->index()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_token_limits');
    }
};
