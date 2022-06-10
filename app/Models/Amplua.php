<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Amplua
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Amplua newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Amplua newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Amplua query()
 * @method static \Illuminate\Database\Eloquent\Builder|Amplua whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Amplua whereName($value)
 * @mixin \Eloquent
 */
class Amplua extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
}
