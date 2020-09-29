<?php

namespace App\Models\Parsers\Telegram;

use App\Repositories\StylesRepository;

class Style
{
    protected StylesRepository $styleRepository;

    private string $name;

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isExists(): bool
    {
        return $this->styleRepository->isExists($this->name);
    }
}
