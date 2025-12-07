<?php

namespace App\Services\WordSources;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

readonly class HttpWordSource implements WordSourceInterface
{
    public function __construct(
        private string $url
    ) {}

    /**
     * @throws ConnectionException
     */
    public function lines(): iterable
    {
        $response = Http::withOptions([
            'stream' => true,
        ])->get($this->url);

        if (! $response->ok()) {
            throw new \RuntimeException("Failed to download word list: {$this->url}");
        }

        $buffer = '';
        $stream = $response->toPsrResponse()->getBody();

        while (! $stream->eof()) {
            // Read an 8 KB chunk (ensuring UTF-8)
            $chunk = $stream->read(8192);
            $chunk = mb_convert_encoding($chunk, 'UTF-8', 'auto');

            $buffer .= $chunk;

            while (($pos = strpos($buffer, "\n")) !== false) {
                $line = trim(substr($buffer, 0, $pos));
                $buffer = substr($buffer, $pos + 1);

                if ($line !== '') {
                    yield $line;
                }
            }
        }

        // Yield remaining lines
        $final = trim($buffer);
        if ($final !== '') {
            yield $final;
        }
    }
}
