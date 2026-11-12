<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plan_accounts', function (Blueprint $table) {
            $table->id();
            // El código se conserva como texto: puede contener puntos finales y códigos repetidos.
            $table->string('code', 50);
            $table->string('name', 500);
            $table->foreignId('parent_id')->nullable()->constrained('plan_accounts')->restrictOnDelete();
            $table->enum('group_type', ['activo', 'pasivo', 'patrimonio', 'ingreso', 'gasto']);
            $table->unsignedTinyInteger('level')->default(1);
            $table->boolean('is_group')->default(false);
            $table->boolean('allows_entries')->default(false);
            $table->unsignedSmallInteger('source_order')->unique();
            $table->unsignedTinyInteger('source_page')->nullable();
            $table->timestamps();

            $table->index('code');
            $table->index(['group_type', 'allows_entries']);
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('plan_accounts');
    }
};
