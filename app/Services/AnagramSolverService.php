<?php

namespace App\Services;

use App\Services\AnagramSolvers\AnagramSolverInterface;

class AnagramSolverService
{
    /**
     * Find anagrams for the given word.
     *
     *
     * @return array<string>
     */
    public function solve(AnagramSolverInterface $solver, string $word, int $wordBaseId): array
    {
        return $solver->find($word, $wordBaseId);
    }
}
