<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('journal_entry_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('journal_entry_id')->constrained('journal_entries')->cascadeOnDelete();
            $table->foreignId('plan_account_id')->constrained('plan_accounts')->restrictOnDelete();
            $table->string('description', 500)->nullable();
            $table->decimal('debit', 14, 2)->default(0);
            $table->decimal('credit', 14, 2)->default(0);
            $table->unsignedSmallInteger('line_order')->default(1);
            $table->timestamps();

            $table->index(['journal_entry_id', 'line_order'], 'journal_lines_entry_order_idx');
            $table->index('plan_account_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_entry_lines');
    }
};
