<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->string('status')->default('agendado')->change();
        });

        DB::table('agendamentos')
            ->where('status', 'concluido')
            ->update(['status' => 'concluido']);

    }

    public function down(): void
    {
        Schema::table('agendamentos', function (Blueprint $table) {
            $table->string('status')->default('agendado')->change();
        });
    }
};
