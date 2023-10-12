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
        Schema::create('acoeshistorico', function (Blueprint $table) {
            $table->id();
            $table->date('data_acao');
            $table->decimal('preco_abertura');
            $table->decimal('preco_mais_alto');
            $table->decimal('preco_mais_baixo');
            $table->decimal('preco_fechamento');
            $table->decimal('preco_fechamento_ajustado');
            $table->unsignedBigInteger('id_acao');
            $table->foreign('id_acao')->references('id')->on('acoes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acoeshistorico');
    }
};
