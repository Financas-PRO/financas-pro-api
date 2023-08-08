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
        Schema::create('aluno_turmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_turma');
            $table->unsignedBigInteger('id_aluno');
            $table->foreign('id_turma')->references('id')->on('turmas');
            $table->foreign('id_aluno')->references('id')->on('alunos');
            $table->boolean("ativo")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aluno_turmas');
    }
};
