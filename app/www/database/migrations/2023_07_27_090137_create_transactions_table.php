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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("hash")->index()->nullable();
            $table->string("client_license_hash")->index()->nullable();
            $table->unsignedBigInteger("product_id")->index();
            $table->timestamp("date_payed")->index()->nullable();
            $table->timestamps();


            $table->foreign("product_id")
                ->on("products")
                ->references("id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
