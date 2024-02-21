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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer("price")->index()->default(0);
            $table->integer("tokens")->index()->default(0);
            $table->unsignedBigInteger("gpt_model_id")->index();


            $table->foreign("gpt_model_id")
                ->on("gpt_models")
                ->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
