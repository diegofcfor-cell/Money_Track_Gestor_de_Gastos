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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('categoria_id')->constrained()->cascadeOnDelete();
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
