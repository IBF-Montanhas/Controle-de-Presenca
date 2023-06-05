<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('titulo')->index();
            $table->longText('descricao')->nullable();
            $table->datetime('previsao_inicio')->nullable();
            $table->datetime('previsao_fim')->nullable();
            $table->datetime('data_inicio')->nullable();
            $table->datetime('data_fim')->nullable();
            $table->longText('nota_interna')->nullable();
            $table->integer('status_enum')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
