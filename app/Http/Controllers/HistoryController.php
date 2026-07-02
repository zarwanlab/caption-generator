<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HistoryService;

class HistoryController extends Controller
{
    protected $historyService;

    public function __construct(HistoryService $historyService)
    {
        $this->historyService = $historyService;
    }

    public function index()
    {
        return response()->json([
            'items' => $this->historyService->getHistory(),
        ]);
    }

    public function clear()
    {
        $this->historyService->clearHistory();

        return response()->json([
            'message' => 'History cleared successfully.',
        ]);
    }
}
