<?php

declare(strict_types=1);


namespace App\Models;

use App\Traits\SeederDataTrait;
use Database\Factories\RefereeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\Referee
 *
 * @property int $id
 * @property int $gender_id
 * @property int $age
 * @property string $first_name
 * @property string $last_name
 * @method static Builder|Referee newModelQuery()
 * @method static Builder|Referee newQuery()
 * @method static Builder|Referee query()
 * @method static Builder|Referee whereAge($value)
 * @method static Builder|Referee whereFirstName($value)
 * @method static Builder|Referee whereGenderId($value)
 * @method static Builder|Referee whereId($value)
 * @method static Builder|Referee whereLastName($value)
 * @mixin Eloquent
 * @method static RefereeFactory factory(...$parameters)
 */
class Referee extends Model
{
    use HasFactory, SeederDataTrait;

    public $timestamps = false;
    protected $guarded = [];

    /**
     * начать матч, остановить матч
     *
     * @param bool $start
     * @return bool
     */
    public function startMatch(bool $start = true): bool
    {
        return $start;
    }


    /**
     * назначить штрафной
     *
     * @return array
     */

    #[ArrayShape(['team' => "int", 'event' => "string"])]
    public function giveFreeKick(): array
    {
        return [
            'team' => rand(0, 1),
            'event' => 'giveFreeKick'
        ];
    }


    /**
     * показать карточку
     *
     * @return array
     */

    #[ArrayShape(['team' => "int", 'color' => "mixed", 'event' => "string"])]
    public function showCard(): array
    {
        // показать карточку (красную или желтую)
        $cardColorChanceArray = self::getArrayFromItem('card_show_color');
        $randomIndex = rand(0, count($cardColorChanceArray) - 1);

        return [
            'team' => rand(0, 1),
            'color' => $cardColorChanceArray[$randomIndex],
            'event' => 'showCard'
        ];
    }

    /**
     * @return bool
     */
    public function timeoutMatch(): bool
    {
        return true;
    }

}
