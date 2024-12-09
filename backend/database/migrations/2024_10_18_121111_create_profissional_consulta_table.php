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
        Schema::create('profissional_consulta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('profissional_id')->constrained('profissionals')->onDelete('cascade');
            $table->foreignId('consulta_id')->constrained('consultas')->onDelete('cascade');
            $table->integer('status')->default(1); // status padrão como 1 (pendente)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissional_consulta');
    }
};
