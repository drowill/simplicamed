<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('profissionals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('cpf')->nullable(); // CPF
            $table->string('endereco')->nullable(); // Endereço
            $table->string('telefone')->nullable(); // Telefone
            $table->string('tipo');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissionals');
    }
};
