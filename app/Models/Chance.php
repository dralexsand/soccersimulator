<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Chance
 *
 * @property int $id
 * @property string $name
 * @property int $percent
 * @property int $min
 * @property int $max
 * @method static \Illuminate\Database\Eloquent\Builder|Chance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Chance query()
 * @method static \Illuminate\Database\Eloquent\Builder|Chance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chance whereMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chance whereMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chance whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Chance wherePercent($value)
 * @mixin \Eloquent
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|Chance whereValue($value)
 */
class Chance extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
}
