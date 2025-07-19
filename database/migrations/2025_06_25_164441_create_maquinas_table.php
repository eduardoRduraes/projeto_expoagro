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
        Schema::create('maquinas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->unique();
            $table->enum('tipo',['emplemento','caminhao','carro','trator']);
            $table->year('ano');
            $table->decimal('horas_totais', 8, 3)->default(0);
            $table->enum('status', ['livre', 'manutencoes','em_servico','inativo'])->default('ativo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinas');
    }
};
