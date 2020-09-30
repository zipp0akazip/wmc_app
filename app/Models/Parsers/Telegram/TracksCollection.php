<?php

namespace App\Models\Parsers\Telegram;

class TracksCollection
{
    private array $tracks = [];

    public function add(Track $track): void
    {
        $this->tracks[] = $track;
    }

    public function getTracks(): array
    {
        return $this->tracks;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->tracks as $track) {
            $result[] = $track->toArray();
        }

        return $result;
    }
}
