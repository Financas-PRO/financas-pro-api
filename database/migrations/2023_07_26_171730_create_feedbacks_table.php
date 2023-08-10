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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('descricao', 500);
            $table->unsignedBigInteger('id_docente');
            $table->unsignedBigInteger('id_grupo');
            $table->foreign('id_docente')->references('id')->on('docentes');
            $table->foreign('id_grupo')->references('id')->on('grupos');
            $table->boolean("ativo")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
