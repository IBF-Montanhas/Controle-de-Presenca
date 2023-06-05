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
        Schema::create('membro_eventos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('evento_id')->index();
            $table->foreign('evento_id')->references('id')
                ->on('eventos')->onDelete('cascade');

            $table->unsignedBigInteger('membro_id')->index();
            $table->foreign('membro_id')->references('id')
                ->on('membros')->onDelete('cascade');

            $table->longText('nota_interna')->nullable();
            $table->boolean('presente')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membro_eventos');
    }
};
