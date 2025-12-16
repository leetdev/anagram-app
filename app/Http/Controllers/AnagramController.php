<?php

namespace App\Http\Controllers;

use App\Http\Requests\FindAnagramsRequest;
use App\Services\AnagramSolvers\AnagramSolverInterface;
use App\Services\AnagramSolverService;
use Illuminate\Contracts\Container\BindingResolutionException;

class AnagramController extends Controller
{
    public function __construct(private readonly AnagramSolverService $service) {}

    public function find(FindAnagramsRequest $request)
    {
        $wordBaseId = $request->validated('wordBaseId');
        $word = $request->validated('word');

        try {
            $solver = app()->make(AnagramSolverInterface::class);
        } catch (BindingResolutionException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'anagrams' => $this->service->solve($solver, $word, $wordBaseId),
        ]);
    }
}
