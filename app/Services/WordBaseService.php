<?php

namespace App\Services;

use App\Services\WordSources\WordSourceInterface;
use Illuminate\Support\Facades\DB;

class WordBaseService
{
    public function ingest(WordSourceInterface $source): int
    {
        $chunkSize = 1000;
        $pending = [];
        $insertCount = 0;

        foreach ($source->lines() as $line) {
            $pending[] = ['word' => $line];

            if (count($pending) >= $chunkSize) {
                $insertCount += $this->insertRows($pending);
                $pending = [];
            }
        }

        // leftover items
        if (!empty($pending)) {
            $insertCount += $this->insertRows($pending);
        }

        return $insertCount;
    }

    private function insertRows(array $rows): int
    {
        return DB::table('words')->insertOrIgnore($rows);
    }
}
