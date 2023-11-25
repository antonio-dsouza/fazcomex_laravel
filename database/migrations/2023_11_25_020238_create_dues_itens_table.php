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
        Schema::create('due_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('due_id')->constrained('dues');
            $table->integer('item')->nullable(false);
            $table->string('nfe_chave', 44)->nullable(false);
            $table->string('nfe_numero', 9)->nullable(false);
            $table->string('nfe_serie', 3)->nullable(false);
            $table->integer('nfe_item')->nullable(false);
            $table->longText('descricao_complementar')->nullable(false);
            $table->string('ncm', 8)->nullable(false);
            $table->decimal('vmle_moeda', 17, 2)->nullable(true);
            $table->decimal('vmcv_moeda', 17, 2)->nullable(true);
            $table->decimal('peso_liquido', 17, 5)->nullable(true);
            $table->string('enquadramento1', 5)->nullable(true);
            $table->string('enquadramento2', 5)->nullable(true);
            $table->string('enquadramento3', 5)->nullable(true);
            $table->string('enquadramento4', 5)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('due_itens');
    }
};
