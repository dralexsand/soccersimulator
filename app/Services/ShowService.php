<?php

declare(strict_types=1);


namespace App\Services;

use App\Models\Stadium;
use App\Models\Stat;
use App\Models\Team;

class ShowService
{
    /**
     * @param $request
     * @return array
     */
    public function getHomeData($request): array
    {
        $data = [];
        foreach ($request as $item) {
            $data[] = [
                'id' => $item->id,
                'stadium' => Stadium::whereId($item->stadium_id)->first(),
                'team_1' => Team::whereId($item->team_1_id)->first(),
                'team_2' => Team::whereId($item->team_2_id)->first(),
                'goals_team_1' => $item->goals_team_1,
                'goals_team_2' => $item->goals_team_2,
            ];
        }

        return $data;
    }

    /**
     * @param int $id
     * @return array
     */
    public function showTranslation(int $id): array
    {
        $item = Stat::whereId($id)->first();

        if (!$item) {
            return [];
        }

        return [
            'id' => $item->id,
            'stadium' => Stadium::whereId($item->stadium_id)->first(),
            'team_1' => Team::whereId($item->team_1_id)->first(),
            'team_2' => Team::whereId($item->team_2_id)->first(),
            'goals_team_1' => $item->goals_team_1,
            'goals_team_2' => $item->goals_team_2,
            'data' => json_decode($item->data, true),
            'team_1_players' => json_decode($item->team_1, true),
            'team_2_players' => json_decode($item->team_2, true),
        ];
    }

    /**
     * @return void
     */
    public function clearStat(): void
    {
        Stat::truncate();
    }

}
