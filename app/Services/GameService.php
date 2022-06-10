<?php

declare(strict_types=1);


namespace App\Services;

use App\Models\Fan;
use App\Models\Player;
use App\Models\Referee;
use App\Models\Stadium;
use App\Models\Stat;
use App\Models\Team;
use DateTime;
use JetBrains\PhpStorm\ArrayShape;

class GameService
{
    protected array $stadium;
    protected Referee $refereeModel;
    protected Player $playerModel;
    protected Fan $fanModel_1;
    protected Fan $fanModel_2;
    protected array $team_1;
    protected array $team_2;
    protected array $tablo;

    protected string $teamName_1;
    protected string $teamName_2;

    public function __construct()
    {
        $this->stadium = (new Stadium())->getRandomStadium();

        $this->refereeModel = new Referee();
        $this->playerModel = new Player();

        $teams = (new Team())->getRandomTeams();

        $teamName_1 = Team::whereId($teams[0])->first();
        $this->teamName_1 = $teamName_1->name;

        $teamName_2 = Team::whereId($teams[1])->first();
        $this->teamName_2 = $teamName_2->name;

        $this->fanModel_1 = new Fan($teams[0]);
        $this->fanModel_2 = new Fan($teams[1]);

        $this->team_1 = (new Player())->createStartingLineUp($teams[0]);
        $this->team_2 = (new Player())->createStartingLineUp($teams[1]);

        $this->tablo = [0, 0];
    }

    /**
     * @param array $event
     * @return array
     */
    #[ArrayShape(['message' => "mixed|string", 'postprocess' => "string", 'data' => "array"])]
    public function processMessage(array $event): array
    {
        $postprocess = "";
        $dataPostprocess = [];
        $message = "";

        switch ($event['event']) {
            case "giveFreeKick":
                $teamName = $event['team'] == 0 ? $this->teamName_1 : $this->teamName_2;
                $message = "Рефери назначает штрафной команде $teamName.";
                break;
            case "showCard":
                $teamName = $event['team'] == 0 ? $this->teamName_1 : $this->teamName_2;
                $team = $event['team'] == 0 ? $this->team_1 : $this->team_2;
                $playerId = rand(0, count($team) - 1);
                $player = array_values($team)[$playerId];

                if ($event['color'] === '1') {
                    //$postprocess = "red_card";
                    $dataPostprocess = [
                        'team_name' => $teamName,
                        'team' => $team,
                        'team_index' => $event['team'],
                        'player' => $player,
                    ];
                    $card = "красную карточку";
                } else {
                    $card = "желтую карточку";
                }

                $message = "Рефери назначает $card, игроку {$player['first_name']} {$player['last_name']}, номер {$player['jersey']} команды $teamName.";

                break;
            case "givePass":
                $teamName = $event['team'] == 0 ? $this->teamName_1 : $this->teamName_2;
                $team = $event['team'] == 0 ? $this->team_1 : $this->team_2;
                $playerId = rand(0, count($team) - 1);
                $player = array_values($team)[$playerId];

                $message = "Игрок {$player['first_name']} {$player['last_name']} под номером {$player['jersey']} команды $teamName дает пас.";

                break;
            case "hitOnGoal":
                $teamName = $event['team'] == 0 ? $this->teamName_1 : $this->teamName_2;
                $team = $event['team'] == 0 ? $this->team_1 : $this->team_2;
                $playerId = rand(0, count($team) - 1);
                $player = array_values($team)[$playerId];

                if ($event['is_goal']) {
                    $postprocess = "goal";

                    $playerByAmplua = $this->playerModel->getPlayerByAmpluaOnHit($team);
                    if (!empty($playerByAmplua)) {
                        $player = $playerByAmplua;
                    }

                    $dataPostprocess = [
                        'team_name' => $teamName,
                        'team' => $team,
                        'team_index' => $event['team'],
                        'player' => $player
                    ];
                    $postMessage = "Гооооол!!!";
                } else {
                    $postMessage = "Мимо!";
                }

                $message = "Игрок {$player['first_name']} {$player['last_name']}, номер {$player['jersey']} команды $teamName бъет по воротам! $postMessage.";

                break;
            case "showAct":
                $message = $event['act'];
                break;
        }

        return [
            'message' => $message,
            'postprocess' => $postprocess,
            'data' => $dataPostprocess,
        ];
    }

    public function processTime($t, array $data)
    {
        $timeHalf = 60 * 45;
        $i = 1;
        while ($i < $timeHalf) {
            $eventDateTime = date('Y-m-d H:i:s', $t);
            $event = $this->getEvent();
            $eventName = $event['event'];

            $dataMessage = $this->processMessage($event);

            $data[] = [
                'event_datetime' => $eventDateTime,
                'event' => $eventName,
                'message' => $dataMessage['message']
            ];

            if (isset($dataMessage['postprocess']) && $dataMessage['postprocess'] != "") {
                switch ($dataMessage['postprocess']) {
                    case "goal":
                        $teamIndex = (int)$dataMessage['data']['team_index'];
                        $this->updateTablo($teamIndex);

                        $t++;
                        $eventDateTime = date('Y-m-d H:i:s', $t);
                        $eventName = "Goal";
                        $message = "Гол!";

                        $data[] = [
                            'event_datetime' => $eventDateTime,
                            'event' => $eventName,
                            'message' => $message
                        ];

                        break;
                    case "red_card":
                        $teamName = $dataMessage['data']['team_name'];
                        $team = $dataMessage['data']['team'];
                        $player = $dataMessage['data']['player'];

                        $t++;
                        $eventDateTime = date('Y-m-d H:i:s', $t);
                        $eventName = "removingPlayerFromField";
                        $message = "Удаление в команде $teamName. Игрок {$player['first_name']} {$player['last_name']} покидает поле.";

                        $data[] = [
                            'event_datetime' => $eventDateTime,
                            'event' => $eventName,
                            'message' => $message
                        ];

                        $teamIndex = $dataMessage['data']['team_index'];

                        if ($teamIndex === 0) {
                            $this->team_1 = $this->playerModel->removingPlayerFromField($player['id'], $team);
                        } else {
                            $this->team_2 = $this->playerModel->removingPlayerFromField($player['id'], $team);
                        }
                        break;
                }
            }


            $t += 1;
            $i++;
        }

        return [
            't' => $t,
            'data' => $data
        ];
    }

    public function saveProcess()
    {
        $data = [
            'stadium_id' => $this->stadium['id'],
            'data' => json_encode($this->process()),
            'team_1_id' => (Team::whereName($this->teamName_1)->first())->id,
            'team_2_id' => (Team::whereName($this->teamName_2)->first())->id,
            'goals_team_1' => $this->tablo[0],
            'goals_team_2' => $this->tablo[1],
            'team_1' => json_encode($this->team_1),
            'team_2' => json_encode($this->team_2),
        ];

        Stat::create($data);

        return $data;
    }

    public function process()
    {
        date_default_timezone_set('Europe/Moscow');

        $data = [];

        $startMatch = $this->refereeModel->startMatch();
        $start = (new DateTime("-2 hours"))->format("Y-m-d H:00:00");

        $data[] = [
            'event_datetime' => $start,
            'event' => 'startMatch',
            'message' => "Матч начался"
        ];

        $t = strtotime($start);
        $t++;

        $dataTime = $this->processTime($t, $data);

        $t = $dataTime['t'];
        $data = $dataTime['data'];

        $timeout = $this->refereeModel->timeoutMatch();
        $t += 1;
        $eventDateTime = date('Y-m-d H:i:s', $t);
        $data[] = [
            'event_datetime' => $eventDateTime,
            'event' => 'timeoutMatch',
            'message' => "Перерыв"
        ];

        $dataTime = $this->processTime($t, $data);
        $t = $dataTime['t'];
        $t++;
        $data = $dataTime['data'];

        $stop = $this->refereeModel->startMatch(false);
        $eventDateTime = date('Y-m-d H:i:s', $t);
        $data[] = [
            'event_datetime' => $eventDateTime,
            'event' => 'stopMatch',
            'message' => "Матч окончен"
        ];

        return $data;
    }

    /**
     * @return mixed
     */
    public function getEvent(): mixed
    {
        $events = [
            $this->refereeModel->giveFreeKick(),
            $this->refereeModel->showCard(),
            $this->fanModel_1->showAct(),
            $this->fanModel_2->showAct(),
            $this->playerModel->givePass(),
            $this->playerModel->hitOnGoal(),
        ];

        $randomIndex = rand(0, count($events) - 1);
        return $events[$randomIndex];
    }

    public function updateTablo(int $index)
    {
        $tablo = (int)$this->tablo[$index];
        $tablo++;
        $this->tablo[$index] = $tablo;
    }
}
