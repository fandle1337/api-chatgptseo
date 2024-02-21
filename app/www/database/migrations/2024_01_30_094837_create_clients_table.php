<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->index()->nullable();
            $table->string("client_license_hash")->index()->nullable()->unique();
            $table->string("tariff_code")->default('demo')->index();
            $table->timestamps();

            $table->foreign('tariff_code')
                ->on('client_tariffs')
                ->references('code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
