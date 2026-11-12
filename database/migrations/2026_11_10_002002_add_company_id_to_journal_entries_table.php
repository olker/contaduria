<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            // Nullable para no afectar asientos antiguos que ya pudieran existir.
            $table->foreignId('company_id')->nullable()->after('user_id')
                  ->constrained('companies')->cascadeOnDelete();
            $table->index(['company_id', 'type', 'date'], 'journal_entries_company_type_date_idx');
        });
    }

    public function down()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropIndex('journal_entries_company_type_date_idx');
            $table->dropConstrainedForeignId('company_id');
        });
    }
};
