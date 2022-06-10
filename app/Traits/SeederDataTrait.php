<?php

declare(strict_types=1);


namespace App\Traits;

trait SeederDataTrait
{

    public static function listGenders()
    {
        return [
            [
                'name' => 'male'
            ],
            [
                'name' => 'female'
            ],
        ];
    }

    public static function listCards()
    {
        return [
            [
                'name' => 'yellow'
            ],
            [
                'name' => 'red'
            ],
        ];
    }

    public static function listEntities()
    {
        return [
            [
                'name' => 'referee'
            ],
            [
                'name' => 'player'
            ],
            [
                'name' => 'fan'
            ],
        ];
    }

    public static function listAmpluas()
    {
        return [
            [
                'name' => 'goalkeeper'
            ],
            [
                'name' => 'defender'
            ],
            [
                'name' => 'midfielder'
            ],
            [
                'name' => 'forward'
            ],
        ];
    }

    public static function getArrayFromItem(string $name)
    {
        $itemValue = self::getItemByName($name);
        return str_split($itemValue['value'], 1);
    }

    public static function getItemByName(string $name)
    {
        $list = self::listChances();

        $data = [];

        foreach ($list as $item) {
            if ($item['name'] === $name) {
                $data = $item;
                break;
            }
        }

        return $data;
    }

    public static function listChances()
    {
        return [
            [
                'name' => 'goalkeeper_count_in_team',
                'value' => '0',
                'min' => 2,
                'max' => 3,
            ],
            [
                'name' => 'defender_count_in_team',
                'value' => '0',
                'min' => 5,
                'max' => 8,
            ],
            [
                'name' => 'midfielder_count_in_team',
                'value' => '0',
                'min' => 5,
                'max' => 8,
            ],
            [
                'name' => 'forward_count_in_team',
                'value' => '0',
                'min' => 3,
                'max' => 5,
            ],
            [
                'name' => 'fan_female_chance',
                'value' => '1112',
                'min' => 0,
                'max' => 0,
            ],
            [
                'name' => 'stadium_capacity',
                'value' => '0',
                'min' => 5000,
                'max' => 10000,
            ],
            [
                'name' => 'hit_on_goal',
                'value' => str_repeat("0", 89) . "1",
                'min' => 0,
                'max' => 0,
            ],
            [
                'name' => 'chance_amplua_on_hit',
                'value' => '1223334444',
                'min' => 0,
                'max' => 0,
            ],
            [
                'name' => 'card_show_color',
                'value' => str_repeat("0", 19) . str_repeat("1", 1),
                'min' => 0,
                'max' => 0,
            ],
        ];
    }
}
