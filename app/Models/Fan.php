<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JetBrains\PhpStorm\ArrayShape;

/**
 * App\Models\Fan
 *
 * @property int $id
 * @property int $team_id
 * @property int $gender_id
 * @property int $age
 * @property string $first_name
 * @property string $last_name
 * @method static Builder|Fan newModelQuery()
 * @method static Builder|Fan newQuery()
 * @method static Builder|Fan query()
 * @method static Builder|Fan whereAge($value)
 * @method static Builder|Fan whereFirstName($value)
 * @method static Builder|Fan whereGenderId($value)
 * @method static Builder|Fan whereId($value)
 * @method static Builder|Fan whereLastName($value)
 * @method static Builder|Fan whereTeamId($value)
 * @mixin Eloquent
 */
class Fan extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];

    protected int $teamId;
    protected string $teamName;

    public function __construct(int $teamId)
    {
        parent::__construct();
        $this->teamId = $teamId;
        $this->teamName = $this->getTeamName();
    }

    /**
     * @return BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return string
     */
    public function getTeamName(): string
    {
        $team = Team::whereId($this->teamId)->first();
        return $team->name;
    }

    /**
     * действия болельщиков
     *
     * @return array
     */
    #[ArrayShape(['act' => "string", 'event' => "string"])]
    public function showAct(): array
    {
        $teamName = $this->teamName;
        $fansActTitle = "Болельщики $teamName";

        $chant = $this->getChants();

        $acts = [
            "$fansActTitle поднимают волну.",
            "$fansActTitle размахивают баннерами.",
            "$fansActTitle выбегают на поле.",
            "$fansActTitle поддерживают команду флагами.",
            "$fansActTitle скандируют: $chant",
        ];

        $randomIndex = rand(0, count($acts) - 1);
        return [
            'act' => $acts[$randomIndex],
            'event' => 'showAct'
        ];
    }

    /**
     * лозунги болельщиков
     *
     * @return string
     */
    public function getChants(): string
    {
        $teamName = $this->teamName;

        $chants = [
            "$teamName! Прорвемся!",
            "$teamName, чемпион!",
            "$teamName, навсегда!",
            "Всех победит $teamName!",
            "Оле, оле, оле! $teamName!",
        ];

        $randomIndex = rand(0, count($chants) - 1);
        return $chants[$randomIndex];
    }

}
