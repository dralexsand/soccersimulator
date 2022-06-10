<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stat
 *
 * @property int $id
 * @property int $team_1_id
 * @property int $team_2_id
 * @property mixed $data
 * @property int $goals_team_1
 * @property int $goals_team_2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Stat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stat query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereGoalsTeam1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereGoalsTeam2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereTeam1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereTeam2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $stadium_id
 * @method static \Illuminate\Database\Eloquent\Builder|Stat whereStadiumId($value)
 */
class Stat extends Model
{
    use HasFactory;

    protected $guarded = [];

/*$table->integer('stadium_id');
$table->integer('team_1_id');
$table->integer('team_2_id');
$table->json('data');
$table->integer('goals_team_1');
$table->integer('goals_team_2');*/


}
