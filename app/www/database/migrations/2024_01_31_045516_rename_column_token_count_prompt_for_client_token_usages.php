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
            $table->renameColumn('token_count_prompt', 'prompt_count_token_in');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_token_usages', function (Blueprint $table) {
            $table->renameColumn('prompt_count_token_in', 'token_count_prompt');
        });
    }
};
