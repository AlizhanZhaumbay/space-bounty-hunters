<?php

namespace Database\Seeders;

use App\Models\HuntLog;
use App\Models\WantedCriminal;
use Illuminate\Database\Seeder;

class BountySeeder extends Seeder
{
    public function run(): void
    {
        $criminals = [
            ['name' => 'Victor Kade', 'nickname' => 'Red Comet', 'reward' => 25000, 'latitude' => 12.4501, 'longitude' => -45.1200, 'location_note' => null, 'difficulty' => 9, 'armed' => true, 'has_crew' => true, 'escape_master' => true],
            ['name' => null, 'nickname' => 'Ghost Signal', 'reward' => 18000, 'latitude' => null, 'longitude' => null, 'location_note' => 'Last seen near the Ganymede relay station', 'difficulty' => 8, 'armed' => false, 'has_crew' => false, 'escape_master' => true],
            ['name' => 'Mira Solano', 'nickname' => 'Ice Queen', 'reward' => 7500, 'latitude' => -33.8675, 'longitude' => 151.2070, 'location_note' => null, 'difficulty' => 6, 'armed' => true, 'has_crew' => false, 'escape_master' => false],
            ['name' => 'Otto Brenn', 'nickname' => 'Scrapyard', 'reward' => 3000, 'latitude' => null, 'longitude' => null, 'location_note' => 'Hiding in the Mars junk belt', 'difficulty' => 3, 'armed' => false, 'has_crew' => true, 'escape_master' => false],
            ['name' => null, 'nickname' => 'Silent Lark', 'reward' => 12000, 'latitude' => 40.7128, 'longitude' => -74.0060, 'location_note' => null, 'difficulty' => 7, 'armed' => true, 'has_crew' => true, 'escape_master' => false],
            ['name' => 'Dex Moreau', 'nickname' => 'Pocket Change', 'reward' => 1500, 'latitude' => null, 'longitude' => null, 'location_note' => 'Casino district, Titan', 'difficulty' => 2, 'armed' => false, 'has_crew' => false, 'escape_master' => true],
        ];

        $ids = array_map(fn (array $row) => WantedCriminal::query()->create($row)->id, $criminals);

        $logs = [
            [0, false, 'Target escaped through an asteroid field.'],
            [0, false, 'Ambushed by his crew at the docking bay.'],
            [1, false, 'Signal vanished before we reached the relay.'],
            [1, false, 'Followed a decoy transmission for two days.'],
            [2, false, 'Shootout in the cargo hold, she slipped away.'],
            [2, true, 'Captured after a long chase on the Sydney ring.'],
            [3, true, 'Found him asleep inside a scrapped freighter.'],
            [4, false, 'Crew blocked the corridor, retreat ordered.'],
            [4, false, 'Wrong ship, intel was outdated.'],
            [5, false, 'Lost him in the crowd at the casino.'],
            [5, true, 'Caught at the poker table, no resistance.'],
            [3, false, 'Crew bribed the port authority, he got away.'],
        ];

        foreach ($logs as [$index, $success, $notes]) {
            HuntLog::query()->create(['criminal_id' => $ids[$index], 'success' => $success, 'notes' => $notes]);
        }
    }
}
