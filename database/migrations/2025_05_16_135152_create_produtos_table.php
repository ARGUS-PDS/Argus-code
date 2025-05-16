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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id('IDProduto'); // Define como chave primária com nome customizado
            $table->integer('EstoqueMinimo');
            $table->integer('EstoqueAtual');
            $table->string('Lucro', 10);
            $table->string('Situacao'); // Usando varchar enquanto enum não for definido
            $table->string('CustoCompra', 10);
            $table->string('Fabricante', 25);
            $table->string('ValorUnitario', 10);
            $table->string('Modelo', 25);
            $table->string('Marca', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
