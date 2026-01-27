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
            $table->foreignId('security_type_id')->nullable()->after('display_symbol')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->dropColumn('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('securities', function (Blueprint $table) {
            $table->string('type')->after('display_symbol');
            $table->dropForeign(['security_type_id']);
            $table->dropColumn('security_type_id');
        });
    }
};
