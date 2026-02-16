<?php

namespace Modules\Statistics\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Statistics\Services\NotesStatisticsService;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function __construct(
        protected NotesStatisticsService $statisticsService
    ) {}

    public function index()
    {
        $stats = $this->statisticsService->getStatistics(Auth::id());

        return view('statistics::index', compact('stats'));
    }

    public function show()
    {
        $stats = $this->statisticsService->getStatistics(Auth::id());

        return response()->json($stats);
    }
}
