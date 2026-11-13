<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $casts = [
        'business_operations' => 'array',
        'tax_obligations' => 'array',
        'sin_registration_verified' => 'boolean',
        'has_employees' => 'boolean',
    ];

    protected $fillable = [
        'user_id',
        'name',
        'nit',
        'society_type',
        'economic_activity',
        'activity_category',
        'business_operations',
        'tax_regime',
        'tax_obligations',
        'sin_registration_verified',
        'has_employees',
        'fiscal_address',
        'legal_representative',
        'currency',
        'fiscal_period',
    ];

    public function journalEntries(): HasMany
    {
        return $this->hasMany(JournalEntry::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}