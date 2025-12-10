<?php

namespace App\Http\Controllers;

use App\Models\WordBase;
use App\Http\Requests\FindAnagramsRequest;

class AnagramController extends Controller
{
    public function find(FindAnagramsRequest $request)
    {
        $wordBaseId = $request->validated('wordBaseId');
        $word = $request->validated('word');

        $wordBase = WordBase::find($wordBaseId);
        $anagrams = $wordBase
            ->sortedWords(sort_string(mb_strtolower($word)))
            ->get(['word'])
            ->pluck('word');

        return response()->json([
            'anagrams' => $anagrams,
        ]);
    }
}
