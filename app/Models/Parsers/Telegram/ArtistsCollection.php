<?php

namespace App\Models\Parsers\Telegram;

class ArtistsCollection
{
    private array $artists = [];

    public function add(Artist $artist): void
    {
        $this->artists[] = $artist;
    }

    public function getLastPosition(): int
    {
        $position = 0;

        foreach ($this->artists as $artist) {
            if ($position < $artist->getPosition()) {
                $position = $artist->getPosition();
            }
        }

        return $position;
    }

    public function getNextPosition(): int
    {
        return $this->getLastPosition() + 1;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->artists as $artist) {
            $result[] = $artist->toArray();
        }

        return $result;
    }
}