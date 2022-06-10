<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\TeamFactory factory(...$parameters)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Player[] $players
 * @property-read int|null $players_count
 */
class Team extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fans()
    {
        return $this->hasMany(Fan::class);
    }

    public function getRandomTeams()
    {
        $teams = [];
        $allTeams = Team::select('id')->get();
        $teamsIds = array_values($allTeams->toArray());
        $randomIndex = rand(1, count($teamsIds) - 1);
        $teams[] = $teamsIds[$randomIndex]['id'];
        unset($teamsIds[$randomIndex]);
        $teamsIds = array_values($teamsIds);
        $randomIndex = rand(1, count($teamsIds) - 1);
        $teams[] = $teamsIds[$randomIndex]['id'];
        return $teams;
    }

}
