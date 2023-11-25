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
        Schema::create('dues', function (Blueprint $table) {
            $table->id();
            $table->string('declarante_cpf_cnpj', 14)->nullable(false);
            $table->string('declarante_razao_social', 255)->nullable(false);
            $table->string('identificacao', 255)->nullable(false);
            $table->string('numero', 50)->nullable(false);
            $table->integer('moeda')->nullable(false);
            $table->char('incoterm', 3)->nullable(false);
            $table->longText('informacoes_complementares')->nullable(true);
            $table->decimal('total_vmle_moeda', 17, 2)->nullable(true);
            $table->decimal('total_vmcv_moeda', 17, 2)->nullable(true);
            $table->decimal('total_peso_liquido', 17, 5)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dues');
    }
};
