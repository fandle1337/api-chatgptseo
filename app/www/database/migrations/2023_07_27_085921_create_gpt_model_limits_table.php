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
        Schema::create('gpt_model_limits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("gpt_model_id")->index()->nullable();
            $table->unsignedBigInteger("client_tariff_id")->index()->nullable();
            $table->integer("limit")->index()->default(0);

            $table->foreign("gpt_model_id")
                ->on("gpt_models")
                ->references("id");

            $table->foreign("client_tariff_id")
                ->on("client_tariffs")
                ->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gpt_model_limits');
    }
};
