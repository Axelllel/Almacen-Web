<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exit_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')
                  ->constrained('products')
                  ->cascadeOnDelete();
            $table->unsignedInteger('cantidad');
            $table->string('destino', 255);
            $table->string('motivo', 100);
            $table->foreignId('responsable_id')
                  ->constrained('usuarios')
                  ->cascadeOnDelete();
            $table->date('fecha_salida');
            $table->text('observaciones')->nullable();
            $table->string('comprobante')->nullable();   // storage path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exit_records');
    }
};
