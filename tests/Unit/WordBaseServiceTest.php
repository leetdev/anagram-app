<?php

use App\Models\WordBase;
use App\Services\WordBaseService;
use Illuminate\Support\Facades\DB;
use App\Services\WordSources\WordSourceInterface;

test('WordBaseService ingests words into the database', function () {
    // Fake word source
    $fakeSource = new class implements WordSourceInterface {
        public function lines(): iterable
        {
            yield 'apple';
            yield 'banana';
            yield 'cherry';
        }
    };

    $service = new WordBaseService();

    $wordBase = WordBase::create([
        'name' => 'Fruits',
        'url' => 'https://example.com/wordlist.txt',
    ]);
    $inserted = $service->ingest($fakeSource, $wordBase->id);

    expect($inserted)->toBe(3)
        ->and(DB::table('words')->count())->toBe(3)
        ->and(DB::table('words')->pluck('word')->toArray())
        ->toEqual(['apple', 'banana', 'cherry']);
});
