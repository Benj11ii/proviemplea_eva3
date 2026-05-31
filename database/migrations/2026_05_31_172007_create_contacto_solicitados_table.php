<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('contactos_solicitados', function (Blueprint $table) {
        $table->uuid('id')->primary();

        // Relaciones foráneas UUID
        $table->foreignUuid('empresa_id')->constrained('empresas')->onDelete('cascade');
        $table->foreignUuid('persona_id')->constrained('personas')->onDelete('cascade');

        $table->string('estado')->default('pendiente');
        // pendiente, contactado, entrevista, seleccionado, no-seleccionado, proceso-cerrado

        $table->text('notas_admin')->nullable();

        $table->timestamp('fecha_contacto')->nullable();
        $table->timestamp('fecha_entrevista')->nullable();
        $table->timestamp('fecha_resultado')->nullable();

        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('contacto_solicitados');
    }
};
