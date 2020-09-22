<?php

namespace App\Models\Parsers\Telegram;

use App\Models\StylesModel;
use App\Repositories\StyleRepository;

class Style
{
    protected StyleRepository $styleRepository;

    private ?string $name;

    public function __construct(StyleRepository $styleRepository)
    {
        $this->styleRepository = $styleRepository;
    }

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
