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
        Schema::create('alunos', function (Blueprint $table) {
            $table->id();
            $table->string("nome", 150);
            $table->string("ra",12);
            $table->boolean("ativo")->default(1);
            $table->unsignedBigInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->unsignedBigInteger('id_curso');
            $table->foreign('id_curso')->references('id')->on('cursos');
            $table->unsignedBigInteger('id_disciplina');
            $table->foreign('id_disciplina')->references('id')->on('disciplinas');
            $table->integer('termo');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
