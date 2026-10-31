<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HuntLog extends Model
{
    public const null UPDATED_AT = null;

    protected $fillable = ['criminal_id', 'success', 'notes'];

    public function criminal(): BelongsTo
    {
        return $this->belongsTo(WantedCriminal::class, 'criminal_id');
    }

    protected function casts(): array
    {
        return [
            'success' => 'boolean',
            'created_at' => 'datetime',
        ];
    }
}
