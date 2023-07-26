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
        Schema::create('acoes', function (Blueprint $table) {
            $table->id();
            $table->string('simbolo',15);
            $table->string('nome_curto',15);
            $table->string('nome_completo', 200);
            $table->decimal('preco_merc_regular');
            $table->decimal('alto_merc_regular');
            $table->decimal('baixo_merc_regular');
            $table->string('intervalo_merc_regular',50);
            $table->decimal('variacao_merc_regular');
            $table->decimal('valor_merc');
            $table->decimal('volume_merc_regular');
            $table->decimal('fecha_ant_merc_regular');
            $table->decimal('abertura_merc_regular');
            $table->string('link_logo', 150);
            $table->decimal('preco_lucro');
            $table->dateTime('data_importacao');
            $table->unsignedBigInteger('id_grupo');
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
        Schema::dropIfExists('acoes');
    }
};
