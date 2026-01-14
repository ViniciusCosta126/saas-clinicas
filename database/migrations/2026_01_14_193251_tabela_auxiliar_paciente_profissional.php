<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paciente_profissional', function (Blueprint $table) {
            $table->id();

            $table->foreignId('paciente_id')
                ->constrained('pacientes')
                ->cascadeOnDelete();

            $table->foreignId('profissional_id')
                ->constrained('profissionais')
                ->cascadeOnDelete();

            $table->foreignId('clinica_id')
                ->constrained('clinicas')
                ->cascadeOnDelete();

            $table->timestamp('iniciado_em')->useCurrent();
            $table->timestamp('finalizado_em')->nullable();

            $table->unique(['paciente_id', 'profissional_id', 'finalizado_em']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paciente_profissional');
    }
};
