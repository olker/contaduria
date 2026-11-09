<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false);
            }
            if (!Schema::hasColumn('users', 'membership_status')) {
                $table->string('membership_status')->default('inactive'); // active, inactive, expired
            }
            if (!Schema::hasColumn('users', 'membership_expires_at')) {
                $table->date('membership_expires_at')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_admin', 'membership_status', 'membership_expires_at']);
        });
    }
};