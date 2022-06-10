<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Efficiency
 *
 * @property int $id
 * @property int $stadium_id
 * @property int $stat_id
 * @property int $player_id
 * @property string $goal_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency whereGoalTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency whereStadiumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency whereStatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Efficiency whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Efficiency extends Model
{
    use HasFactory;

    protected $guarded = [];
}
