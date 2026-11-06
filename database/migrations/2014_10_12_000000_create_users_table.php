<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            
            // Campos de control y membresía
            $table->boolean('is_admin')->default(false); // Define si es administrador
            $table->string('membership_status')->default('inactive'); // active, inactive, expired
            $table->timestamp('membership_expires_at')->nullable(); // Fecha de expiración de membresía
            
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
