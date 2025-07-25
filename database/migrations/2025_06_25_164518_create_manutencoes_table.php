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
        Schema::create('manutencoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maquina_id')->constrained('maquinas')->cascadeOnDelete();
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['preventiva', 'corretiva']);
            $table->enum('status', ['livre', 'manutencao', 'inativaclear']);
            $table->decimal('custo', 10,3)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manutencoes');
    }
};
