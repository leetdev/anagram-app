<?php

namespace App\Http\Controllers;

use App\Models\WordBase;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\FetchWordBaseRequest;
use App\Services\WordBaseService;
use App\Services\WordSources\WordSourceInterface;

class WordBaseController extends Controller
{
    public function __construct(private readonly WordBaseService $service)
    {
    }

    public function fetch(FetchWordBaseRequest $request): JsonResponse
    {
        try {
            $name = $request->validated('name');
            $url = $request->validated('url');
            $wordBase = WordBase::create([
                'name' => $name,
                'url' => $url,
            ]);

            // Use factory binding to plug in the word source URL and resolve the implementation
            app()->instance('word_source_url', $url);
            $source = app()->make(WordSourceInterface::class);

            $inserted = $this->service->ingest($source, $wordBase->id);

            return response()->json([
                'status' => 'success',
                'inserted' => $inserted,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
