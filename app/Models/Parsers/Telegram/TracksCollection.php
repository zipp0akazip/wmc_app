<?php

namespace App\Models\Parsers\Telegram;

class TracksCollection
{
    private array $tracks = [];

    public function add(Track $track): void
    {
        $this->tracks[] = $track;
    }
}
