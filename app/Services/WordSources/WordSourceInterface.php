<?php

namespace App\Services\WordSources;

interface WordSourceInterface
{
    /**
     * Return an iterable stream of lines (strings) from the word source.
     *
     * Each yielded value should be a raw line without newline characters.
     */
    public function lines(): iterable;
}
