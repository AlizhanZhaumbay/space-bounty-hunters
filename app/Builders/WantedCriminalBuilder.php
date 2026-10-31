<?php

namespace App\Builders;

use Illuminate\Database\Eloquent\Builder;

class WantedCriminalBuilder extends Builder
{
    public function applyFilters(array $filters): self
    {
        foreach (['armed', 'has_crew', 'escape_master'] as $flag) {
            if (isset($filters[$flag])) {
                $this->where("wanted_criminals.$flag", $filters[$flag]);
            }
        }

        return $this
            ->when(isset($filters['min_reward']), fn (self $q) => $q->where('wanted_criminals.reward', '>=', (int) $filters['min_reward']))
            ->when(isset($filters['max_reward']), fn (self $q) => $q->where('wanted_criminals.reward', '<=', (int) $filters['max_reward']))
            ->sortBy($filters['sort'] ?? null);
    }

    private function sortBy(?string $sort): self
    {
        return match ($sort) {
            'reward' => $this->orderBy('wanted_criminals.reward')->orderBy('wanted_criminals.id'),
            '-reward' => $this->orderByDesc('wanted_criminals.reward')->orderBy('wanted_criminals.id'),
            default => $this->orderBy('wanted_criminals.id'),
        };
    }
}
