<?php

namespace App\Models\Parsers\Telegram;

use App\Repositories\StyleRepository;

class Style
{
    protected StyleRepository $styleRepository;

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

    private function getStyleRepository(): StyleRepository
    {
        if (!isset($this->styleRepository)) {
            $this->styleRepository = resolve(StyleRepository::class);
        }

        return $this->styleRepository;
    }
}
