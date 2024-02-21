<?php

use App\Enum\EnumOrderType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->index();
            $table->unsignedBigInteger('client_id')->index();
            $table->integer('price')->index();
            $table->timestamp('date_payed')->nullable()->index();
            $table->enum('type', [
                EnumOrderType::TYPE_PAYMENT->name,
                EnumOrderType::TYPE_PREINSTALL->name,
                EnumOrderType::TYPE_MANUAL->name
            ])->default(EnumOrderType::TYPE_MANUAL->name)->index();
            $table->timestamps();

            $table->foreign('client_id')->on('clients')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
