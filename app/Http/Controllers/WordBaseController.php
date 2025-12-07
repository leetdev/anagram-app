<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\FetchWordBaseRequest;
use App\Services\WordBaseService;
use App\Services\WordSources\WordSourceInterface;

class WordBaseController extends Controller
{
    public function __construct(private readonly WordBaseService $service) {}

    public function fetch(FetchWordBaseRequest $request): JsonResponse
    {
        try {
            $url = $request->validated('url');

            // Use factory binding to plug in the word source URL and resolve the implementation
            app()->instance('word_source_url', $url);
            $source = app()->make(WordSourceInterface::class);

            $inserted = $this->service->ingest($source);

            return response()->json([
                'status' => 'success',
                'inserted' => $inserted,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
