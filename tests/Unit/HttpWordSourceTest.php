<?php

use App\Services\WordSources\HttpWordSource;
use Illuminate\Support\Facades\Http;

test('HttpWordSource streams lines from remote file', function () {
    $body = "apple\nbanana\ncherry\n";

    Http::fake([
        '*/words.txt' => Http::response($body, 200),
    ]);

    $source = new HttpWordSource('https://example.com/words.txt');

    $lines = iterator_to_array($source->lines());

    expect($lines)->toEqual(['apple', 'banana', 'cherry']);
});
