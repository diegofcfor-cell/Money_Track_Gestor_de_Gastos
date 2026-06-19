<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metas_ahorro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nombre');
            $table->decimal('monto_objetivo', 12, 2);
            $table->decimal('monto_actual', 12, 2)->default(0);
            $table->date('fecha_limite')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metas_ahorro');
    }
};
