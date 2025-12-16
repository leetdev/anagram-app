<?php

namespace App\Services\AnagramSolvers;

interface AnagramSolverInterface
{
    /**
     * Find anagrams for the given word in the given word base.
     *
     *
     * @return array<string>
     */
    public function find(string $word, int $wordBaseId): array;
}
