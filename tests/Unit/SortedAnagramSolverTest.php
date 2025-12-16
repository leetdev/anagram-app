<?php

use App\Models\WordBase;
use App\Services\AnagramSolvers\SortedAnagramSolver;
use App\Services\WordBaseService;
use App\Services\WordSources\WordSourceInterface;

test('SortedAnagramSolver finds anagrams for given words', function () {
    $wordBase = WordBase::create([
        'name' => 'Fruit List',
        'url' => 'https://example.com/wordlist.txt',
    ]);
    $fakeSource = new class implements WordSourceInterface
    {
        public function lines(): iterable
        {
            yield 'apple';
            yield 'banana';
            yield 'cherry';
            yield 'peach';
        }
    };
    $service = new WordBaseService;
    $service->ingest($fakeSource, $wordBase->id);

    $solver = new SortedAnagramSolver;
    expect($solver->find('cheap', $wordBase->id))->toBe(['peach']);
});
