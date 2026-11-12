<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanAccountObservation extends Model
{
    protected $fillable = [
        'observation_key', 'plan_account_id', 'issue_type',
        'description', 'source_excerpt', 'source_page',
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(PlanAccount::class, 'plan_account_id');
    }
}
