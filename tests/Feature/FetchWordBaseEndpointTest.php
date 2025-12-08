<?php

use App\Models\WordBase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('POST /word-base/fetch downloads and stores words', function () {
    Http::fake([
        '*/wordlist.txt' => Http::response("apple\nbanana\ncherry", 200),
    ]);

    $response = $this->postJson('/api/word-base/fetch', [
        'name' => 'Fruit List',
        'url' => 'https://example.com/wordlist.txt',
    ]);

    $response->assertOk()
        ->assertJson([
            'status' => 'success',
            'inserted' => 3,
        ]);

    expect(DB::table('words')->count())->toBe(3);

    $wordBase = WordBase::first();

    expect($wordBase->name)->toBe('Fruit List')
        ->and($wordBase->url)->toBe('https://example.com/wordlist.txt');
});
