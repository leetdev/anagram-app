<?php

namespace App\Services;

use App\Services\WordSources\WordSourceInterface;
use Illuminate\Support\Facades\DB;

class WordBaseService
{
    public function ingest(WordSourceInterface $source, int $wordBaseId): int
    {
        $chunkSize = 1000;
        $pending = [];
        $insertCount = 0;

        foreach ($source->lines() as $line) {
            $word = mb_strtolower($line);
            $sorted = sort_string($word);

            $pending[] = [
                'word' => $word,
                'sorted' => $sorted,
            ];

            if (count($pending) >= $chunkSize) {
                $insertCount += $this->insertRows($pending, $wordBaseId);
                $pending = [];
            }
        }

        // leftover items
        if (!empty($pending)) {
            $insertCount += $this->insertRows($pending, $wordBaseId);
        }

        return $insertCount;
    }

    private function insertRows(array $rows, int $wordBaseId): int
    {
        $rows = array_map(fn($row) => $row + ['word_base_id' => $wordBaseId], $rows);
        return DB::table('words')->insertOrIgnore($rows);
    }
}
