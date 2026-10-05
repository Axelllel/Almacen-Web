<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('categoria', 100);
            $table->decimal('precio', 12, 2)->default(0.00);
            $table->unsignedInteger('stock')->default(0);
            $table->string('codigo', 100)->nullable()->unique();
            $table->string('unidad', 20)->default('pza');
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();   // storage path
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
