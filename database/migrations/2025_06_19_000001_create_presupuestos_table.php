<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('categoria_id');
            $table->decimal('limite_mensual', 12, 2);
            $table->tinyInteger('mes');
            $table->smallInteger('año');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
};
