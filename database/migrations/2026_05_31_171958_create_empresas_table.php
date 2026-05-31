<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('empresas', function (Blueprint $table) {
        $table->uuid('id')->primary();

        $table->string('nombre_empresa');
        $table->string('rut_empresa')->unique();
        $table->string('email')->unique();
        $table->string('logo_url')->nullable();
        $table->string('rubro')->nullable();
        $table->string('tipo_empresa');
        $table->text('presentacion')->nullable();
        $table->json('beneficios')->nullable();

        // Contacto
        $table->string('contacto_nombre');
        $table->string('contacto_email');
        $table->string('contacto_telefono', 20)->nullable();

        // Estado
        $table->boolean('validado')->default(false);
        $table->boolean('activo')->default(true);

        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
