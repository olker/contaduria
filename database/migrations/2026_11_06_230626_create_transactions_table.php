<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade'); // Relacionado a la empresa
            $table->enum('type', ['compra', 'venta']); // Tipo de transacción
            $table->date('date'); // Fecha de la factura/recibo
            $table->string('invoice_number')->nullable(); // Número de factura o recibo
            $table->string('nit_provider_client')->nullable(); // NIT del proveedor o cliente
            $table->string('name_provider_client'); // Razón social (Nombre del Proveedor o Cliente)
            
            // Montos detallados para contabilidad e impuestos
            $table->decimal('total_amount', 12, 2); // Monto total pagado/cobrado
            $table->decimal('subtotal', 12, 2); // Importe base para impuestos
            $table->decimal('tax_amount', 12, 2)->default(0); // IVA (Crédito Fiscal en compras / Débito Fiscal en ventas)
            
            $table->string('image_path')->nullable(); // Ruta de la foto del recibo/factura (captura por cámara)
            $table->text('glosa')->nullable(); // Descripción o concepto de la transacción
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};