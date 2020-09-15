<?php

namespace App\Models\Parsers\Telegram;

class ReleasesCollection
{
    private array $releases = [];

    public function add(Release $release): void
    {
        $this->releases[] = $release;
    }
}
