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
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carteira_id')->constrained('carteiras')->onDelete('cascade'); 
            $table->foreignId('carteira_origem_id')->nullable()->constrained('carteiras')->onDelete('cascade');
            $table->foreignId('carteira_destino_id')->nullable()->constrained('carteiras'); 
            $table->enum('tipo', ['deposito', 'transferencia', 'reversao']);
            $table->decimal('valor', 15, 2);
            $table->boolean('reversao')->default(false);
            $table->foreignId('transacao_revertida_id')->nullable()->constrained('transacoes'); // transação original que foi revertida 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transacoes');
    }
};
