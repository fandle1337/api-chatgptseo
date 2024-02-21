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
            $table->string('gpt_model_code')->after('client_id')->index();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_token_usages', function (Blueprint $table) {
            if (Schema::hasColumn('client_token_usages', 'gpt_model_code')) {

                $table->dropColumn('gpt_model_code');
            }
        });
    }
};
