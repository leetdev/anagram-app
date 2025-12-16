<?php

namespace App\Services\AnagramSolvers;

use App\Models\WordBase;

class SortedAnagramSolver implements AnagramSolverInterface
{
    public function find(string $word, int $wordBaseId): array
    {
        $wordBase = WordBase::find($wordBaseId);
        $anagrams = $wordBase
            ->sortedWords(sort_string(mb_strtolower($word)))
            ->get(['word'])
            ->pluck('word');

        return $anagrams->toArray();
    }
}
