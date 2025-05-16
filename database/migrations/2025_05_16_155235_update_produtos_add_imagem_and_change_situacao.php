<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->string('imagem')->nullable(); // adiciona a coluna imagem
            $table->boolean('situacao')->default(true)->change(); // altera para boolean
        });
    }

    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('imagem'); // remove imagem
            $table->string('situacao')->change(); // volta para string
        });
    }
};
