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
        return $this->getStyleRepository()->isExists($this->name);
    }

    private function getStyleRepository(): StylesRepository
    {
        if (!isset($this->styleRepository)) {
            $this->styleRepository = resolve(StylesRepository::class);
        }

        return $this->styleRepository;
    }
}
