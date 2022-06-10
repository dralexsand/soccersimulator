<?php

namespace App\Http\Controllers;

use App\Models\Stat;
use App\Services\ShowService;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    protected ShowService $showService;

    public function __construct(ShowService $showService)
    {
        $this->showService = $showService;
    }

    public function index()
    {
        $stats = Stat::select(
            [
                'id',
                'stadium_id',
                'team_1_id',
                'team_2_id',
                'goals_team_1',
                'goals_team_2',
            ]
        )
            ->get();

        $data = $this->showService->getHomeData($stats);

        return view('pages.home', [
            'data' => $data
        ]);
    }

    public function translation(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        $data = $this->showService->showTranslation((int)$validated['id']);

        $translates = [
          '1' => 'Вратарь',
          '2' => 'Защитник',
          '3' => 'Полузащитник',
          '4' => 'Нападающий',
        ];

        return view('pages.translation', [
            'data' => $data,
            'translates' => $translates
        ]);
    }

    public function stats()
    {
        return view('pages.stats');
    }
}
