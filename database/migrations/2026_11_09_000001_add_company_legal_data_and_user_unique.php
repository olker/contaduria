<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('society_type')->nullable()->after('nit');
            $table->string('economic_activity')->nullable()->after('society_type');
            $table->string('fiscal_address', 500)->nullable()->after('economic_activity');
            $table->string('legal_representative')->nullable()->after('fiscal_address');
            $table->unique('user_id', 'companies_user_id_unique');
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropUnique('companies_user_id_unique');
            $table->dropColumn([
                'society_type',
                'economic_activity',
                'fiscal_address',
                'legal_representative',
            ]);
        });
    }
};
