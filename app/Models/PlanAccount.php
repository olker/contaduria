<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PlanAccount extends Model
{
    protected $fillable = [
        'code', 'name', 'parent_id', 'group_type', 'level',
        'is_group', 'allows_entries', 'source_order', 'source_page',
    ];

    protected $casts = [
        'is_group' => 'boolean',
        'allows_entries' => 'boolean',
        'level' => 'integer',
        'source_order' => 'integer',
        'source_page' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PlanAccount::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(PlanAccount::class, 'parent_id')->orderBy('source_order');
    }

    public function observations(): HasMany
    {
        return $this->hasMany(PlanAccountObservation::class);
    }

    public function getFullLabelAttribute(): string
    {
        return $this->code . ' — ' . trim($this->name);
    }
}
