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
        if (Schema::hasColumn('categorias', 'tipo')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->dropColumn('tipo');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('categorias', 'tipo')) {
            Schema::table('categorias', function (Blueprint $table) {
                $table->enum('tipo', ['ingreso', 'egreso'])->nullable();
            });
        }
    }
};
