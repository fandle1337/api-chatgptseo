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
        Schema::table('client_token_usages', function (Blueprint $table) {
            $table->dropColumn('client_license_hash');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_token_usages', function (Blueprint $table) {
            $table->string('client_license_hash')->after('id')->nullable()->index();
        });
    }
};
