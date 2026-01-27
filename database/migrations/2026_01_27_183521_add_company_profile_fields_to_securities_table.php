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
        Schema::table('securities', function (Blueprint $table) {
            $table->foreignId('country_id')->nullable()->after('currency_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('exchange_id')->nullable()->after('country_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('logo')->nullable()->after('exchange_id');
            $table->decimal('market_capitalization', 20, 2)->nullable()->after('logo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->dropForeign(['country_id']);
            $table->dropForeign(['exchange_id']);
            $table->dropColumn(['country_id', 'exchange_id', 'logo', 'market_capitalization']);
        });
    }
};
