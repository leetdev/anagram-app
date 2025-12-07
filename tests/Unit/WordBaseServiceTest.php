<?php

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

    $inserted = $service->ingest($fakeSource);

    expect($inserted)->toBe(3)
        ->and(DB::table('words')->count())->toBe(3)
        ->and(DB::table('words')->pluck('word')->toArray())
        ->toEqual(['apple', 'banana', 'cherry']);
});
