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
        if (Schema::hasColumn('movimientos', 'usuario_id')) {
            Schema::table('movimientos', function (Blueprint $table) {
                $table->dropColumn('usuario_id');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('movimientos', 'usuario_id')) {
            Schema::table('movimientos', function (Blueprint $table) {
                $table->integer('usuario_id')->nullable();
            });
        }
    }
};
