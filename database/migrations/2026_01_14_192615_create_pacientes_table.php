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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinica_id')
                ->constrained('clinicas')
                ->cascadeOnDelete();
            $table->string("nome", 255)->nullable(false);
            $table->string("email", 255);
            $table->string("telefone", 11)->nullable(false);
            $table->date('aniversario');
            $table->timestamps();
            $table->index(['clinica_id', 'nome']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
