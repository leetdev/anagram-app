<?php

use App\Models\WordBase;
use App\Services\WordBaseService;
use App\Services\WordSources\WordSourceInterface;

it('can find complete anagrams of a given word', function () {
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

    $response = $this->postJson('/api/find', [
        'wordBaseId' => $wordBase->id,
        'word' => 'cheap',
    ]);
    $response->assertOk()
        ->assertJson([
            'anagrams' => ['peach'],
        ]);

    expect($response->json('anagrams'))->toHaveCount(1);
});
