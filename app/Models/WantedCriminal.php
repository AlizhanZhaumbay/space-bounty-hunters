<?php

namespace App\Models;

use App\Builders\WantedCriminalBuilder;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseEloquentBuilder(WantedCriminalBuilder::class)]
class WantedCriminal extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function huntLogs(): HasMany
    {
        return $this->hasMany(HuntLog::class, 'criminal_id');
    }

    protected function casts(): array
    {
        return [
            'reward' => 'integer',
            'latitude' => 'float',
            'longitude' => 'float',
            'difficulty' => 'integer',
            'armed' => 'boolean',
            'has_crew' => 'boolean',
            'escape_master' => 'boolean',
        ];
    }
}
