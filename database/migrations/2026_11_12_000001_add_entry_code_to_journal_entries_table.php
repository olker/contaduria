<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->string('entry_code', 20)->nullable()->after('company_id');
        });

        // Asigna AD1 al asiento de apertura y continúa la numeración de los asientos existentes.
        $companyIds = DB::table('journal_entries')
            ->whereNotNull('company_id')
            ->distinct()
            ->pluck('company_id');

        foreach ($companyIds as $companyId) {
            $entries = DB::table('journal_entries')
                ->where('company_id', $companyId)
                ->orderByRaw("CASE WHEN type = 'apertura' THEN 0 ELSE 1 END")
                ->orderBy('id')
                ->get(['id', 'type']);

            $number = 1;
            foreach ($entries as $entry) {
                DB::table('journal_entries')
                    ->where('id', $entry->id)
                    ->update(['entry_code' => 'AD' . $number]);
                $number++;
            }
        }

        Schema::table('journal_entries', function (Blueprint $table) {
            $table->unique(['company_id', 'entry_code'], 'journal_entries_company_code_unique');
        });
    }

    public function down()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropUnique('journal_entries_company_code_unique');
            $table->dropColumn('entry_code');
        });
    }
};
