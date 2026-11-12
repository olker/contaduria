<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('plan_account_observations', function (Blueprint $table) {
            $table->id();
            $table->string('observation_key', 100)->unique();
            $table->foreignId('plan_account_id')->nullable()->constrained('plan_accounts')->nullOnDelete();
            $table->string('issue_type', 60);
            $table->text('description');
            $table->text('source_excerpt')->nullable();
            $table->unsignedTinyInteger('source_page')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('plan_account_observations');
    }
};
