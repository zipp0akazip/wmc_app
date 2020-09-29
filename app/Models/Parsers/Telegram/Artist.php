<?php

namespace App\Models\Parsers\Telegram;

class Artist
{
    private ?string $name;
    private ?int $position;
    private bool $isRemixer = false;

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

    public function setIsRemixer(): void
    {
        $this->isRemixer = true;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'position' => $this->position,
            'is_remixer' => $this->isRemixer,
        ];
    }
}
