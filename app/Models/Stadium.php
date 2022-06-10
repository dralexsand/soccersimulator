<?php

namespace App\Models;

use Database\Factories\StadiumFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stadium
 *
 * @method static Builder|Stadium newModelQuery()
 * @method static Builder|Stadium newQuery()
 * @method static Builder|Stadium query()
 * @mixin Eloquent
 * @method static StadiumFactory factory(...$parameters)
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @method static Builder|Stadium whereCapacity($value)
 * @method static Builder|Stadium whereId($value)
 * @method static Builder|Stadium whereName($value)
 */
class Stadium extends Model
{
    use HasFactory;

    protected $table = 'stadiums';

    public $timestamps = false;
    protected $guarded = [];


    /**
     * @return array
     */
    public function getRandomStadium(): array
    {
        $stadiums = $this->get();
        $stadiumsArray = array_values($stadiums->toArray());
        $randomIndex = rand(1, count($stadiumsArray) - 1);
        return $stadiumsArray[$randomIndex];
    }
}
