<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('activity_category', 40)->nullable()->after('economic_activity');
            $table->json('business_operations')->nullable()->after('activity_category');
            $table->string('tax_regime', 40)->nullable()->after('business_operations');
            $table->json('tax_obligations')->nullable()->after('tax_regime');
            $table->boolean('sin_registration_verified')->default(false)->after('tax_obligations');
            $table->boolean('has_employees')->default(false)->after('sin_registration_verified');
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'activity_category',
                'business_operations',
                'tax_regime',
                'tax_obligations',
                'sin_registration_verified',
                'has_employees',
            ]);
        });
    }
};
