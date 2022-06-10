<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\SeederDataTrait;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\Player
 *
 * @property int $id
 * @property int $team_id
 * @property int $gender_id
 * @property int $age
 * @property string $first_name
 * @property string $last_name
 * @property string $amplua
 * @property string $jersey
 * @property int $is_captain
 * @method static Builder|Player newModelQuery()
 * @method static Builder|Player newQuery()
 * @method static Builder|Player query()
 * @method static Builder|Player whereAge($value)
 * @method static Builder|Player whereAmplua($value)
 * @method static Builder|Player whereFirstName($value)
 * @method static Builder|Player whereGenderId($value)
 * @method static Builder|Player whereId($value)
 * @method static Builder|Player whereIsCaptain($value)
 * @method static Builder|Player whereJersey($value)
 * @method static Builder|Player whereLastName($value)
 * @method static Builder|Player whereTeamId($value)
 * @mixin Eloquent
 * @property-read Team|null $team
 */
class Player extends Model
{
    use HasFactory, SeederDataTrait;

    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * дать пас
     *
     * @return array
     */
    #[ArrayShape(['team' => "int", 'event' => "string"])]
    public function givePass(): array
    {
        return [
            'team' => rand(0, 1),
            'event' => 'givePass'
        ];
    }

    /**
     * ударить по воротам, гол, если is_goal=true
     *
     * @return array
     */
    #[ArrayShape(['team' => "mixed", 'is_goal' => "bool", 'event' => "string"])]
    public function hitOnGoal(): array
    {
        $chanceToGoalArray = self::getArrayFromItem('hit_on_goal');
        $randomIndex = rand(0, count($chanceToGoalArray) - 1);

        return [
            'team' => rand(0, 1),
            'is_goal' => (int)$chanceToGoalArray[$randomIndex] === 1,
            'event' => 'hitOnGoal'
        ];
    }

    /**
     * Получение игрока для удара
     * С учетом верятности, для нападающих - больше, для защитников меньше
     *
     * @param array $team
     * @return array
     */
    public function getPlayerByAmpluaOnHit(array $team): array
    {
        // Амплуа игрока для удара, случайно, с учетом вероятности
        $chanceToHitArray = self::getArrayFromItem('chance_amplua_on_hit');
        $randomIndex = rand(0, count($chanceToHitArray) - 1);
        $ampluaId = $chanceToHitArray[$randomIndex];

        // Игрок с выбранным амплуа, случайно, с учетом вероятности
        $playersByAmplua = $this->getPlayerByAmplua($team, (int)$ampluaId);

        if (empty($playersByAmplua)) {
            return [];
        } else {
            $randomIndex = rand(0, count($playersByAmplua) - 1);
            return array_values($playersByAmplua)[$randomIndex];
        }
    }

    /**
     * Формирование стартового состава
     *
     * @param int $teamId
     * @return array
     */
    public function createStartingLineUp(int $teamId): array
    {
        $allPlayers = Player::whereTeamId($teamId)->get();

        $team = [];

        $dataPlayers = $allPlayers->toArray();

        $captainArray = $this->getCaptain($dataPlayers);
        $captain = array_values($captainArray)[0];
        $captainAmpluaId = $captain['amplua'];

        $team[$captain['id']] = $captain;

        $playersByAmplua = $this->getAllTeamByAmplua($dataPlayers, $captainAmpluaId);

        foreach ($playersByAmplua as $playerAmplua) {
            $players = $this->filterRandom(
                $playerAmplua['players'],
                $playerAmplua['limit']
            );

            foreach ($players as $player) {
                $team[$player['id']] = $player;
            }
        }

        return $team;
    }

    /**
     * Получение состава команды
     *
     * @param array $dataPlayers
     * @param int $captainAmpluaId
     * @return array
     */
    public function getAllTeamByAmplua(array $dataPlayers, int $captainAmpluaId = 0): array
    {
        $limits = $this->getLimits();

        if ($captainAmpluaId) {
            $limits[$captainAmpluaId]--;
        }

        $players = [];

        foreach ($limits as $keyLimit => $limit) {
            $players[] = [
                'players' => $this->getPlayerByAmplua($dataPlayers, (int)$keyLimit),
                'limit' => $limit,
            ];
        }

        return $players;
    }

    /**
     * Лимиты по амплуа
     *
     * @return int[]
     */
    #[ArrayShape(['1' => "int", '2' => "int", '3' => "int", '4' => "int"])]
    public function getLimits(): array
    {
        return [
            '1' => 1,
            '2' => 3,
            '3' => 4,
            '4' => 3,
        ];
    }

    /**
     * Случайный отбор игроков, с учетом лимита по амплуа
     *
     * @param array $team
     * @param int $limit
     * @return array
     */
    public function filterRandom(array $team, int $limit): array
    {
        $players = [];
        $team = array_values($team);
        while ($limit > 0) {
            $randomIndex = rand(0, count($team) - 1);
            $players[$team[$randomIndex]['id']] = $team[$randomIndex];

            unset($team[$randomIndex]);
            $team = array_values($team);

            $limit--;
        }

        return $players;
    }

    /**
     * Получить капитана
     *
     * @param array $team
     * @return array
     */
    public function getCaptain(array $team): array
    {
        return array_filter($team, function ($player) {
            return $player['is_captain'] === 1;
        });
    }

    /**
     * Получить игрока по амплуа, не капитана
     *
     * @param array $team
     * @param int $ampluaId
     * @return array
     */
    public function getPlayerByAmplua(array $team, int $ampluaId): array
    {
        return array_filter($team, function ($player) use ($ampluaId) {
            return (int)$player['amplua'] === $ampluaId && $player['is_captain'] !== 1;
        });
    }


    /**
     * Удаление игрока после красной карточки
     *
     * @param int $playerId
     * @param array $team
     * @return array
     */
    public function removingPlayerFromField(int $playerId, array $team): array
    {
        unset($team[$playerId]);
        return $team;
    }


}
