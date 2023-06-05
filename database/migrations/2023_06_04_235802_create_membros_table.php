<?php

use App\Models\Membro;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('membros', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('nome');
            $table->string('sobrenome')->nullable();
            $table->string('nome_amigavel')->nullable();
            $table->enum('sexo', ['m', 'f'])->index()->nullable();
            $table->integer('status_enum')->nullable()->index()->default(Membro::STATUS_ATIVO);
            $table->integer('tipo_enum')->nullable()->index();
            $table->dateTime('data_de_nascimento')->nullable()->index();
            $table->dateTime('membro_desde')->nullable()->index();
            $table->dateTime('primeiro_registro')->nullable()->index();
            $table->longText('nota_publica')->nullable();
            $table->longText('nota_interna')->nullable();
            $table->json('telefones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membros');
    }
};
