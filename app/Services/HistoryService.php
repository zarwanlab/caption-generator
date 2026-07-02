<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class HistoryService
{
    protected string $historyFile = 'history/instagram-caption-generator.json';

    public function saveHistory(array $entry): array
    {
        $history = $this->getHistory();
        array_unshift($history, $entry);
        $history = array_slice($history, 0, 20);

        Storage::disk('local')->put(
            $this->historyFile,
            json_encode($history, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return $history;
    }

    public function getHistory(): array
    {
        if (Storage::disk('local')->exists($this->historyFile)) {
            $history = json_decode(Storage::disk('local')->get($this->historyFile), true);

            return is_array($history) ? $history : [];
        }

        return [];
    }

    public function clearHistory(): void
    {
        if (Storage::disk('local')->exists($this->historyFile)) {
            Storage::disk('local')->delete($this->historyFile);
        }
    }
}
