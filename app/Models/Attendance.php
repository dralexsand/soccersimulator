<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Attendance
 *
 * @property int $id
 * @property int $stadium_id
 * @property int $stat_id
 * @property int $fan_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereFanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStadiumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereStatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $entity_id
 * @property int $item_id
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereEntityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attendance whereItemId($value)
 */
class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [];
}
