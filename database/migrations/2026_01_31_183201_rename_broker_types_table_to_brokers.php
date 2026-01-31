<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('broker_types')) {
            Schema::rename('broker_types', 'brokers');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('brokers')) {
            Schema::rename('brokers', 'broker_types');
        }
    }
};
