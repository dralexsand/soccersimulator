<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Player;
use App\Services\GameService;
use App\Services\ShowService;
use Illuminate\Http\Request;

class GameController extends Controller
{
    protected GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function run()
    {
        return $this->gameService->saveProcess();
    }

    public function clear()
    {
        (new ShowService())->clearStat();
    }

}
