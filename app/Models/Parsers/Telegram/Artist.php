<?php

namespace App\Models\Parsers\Telegram;

class Artist
{
    private ?string $name;
    private ?int $position;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setPosition(?int $position): void
    {
        $this->position = $position;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }
}
