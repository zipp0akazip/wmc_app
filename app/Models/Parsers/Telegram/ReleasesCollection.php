<?php

namespace App\Models\Parsers\Telegram;

class ReleasesCollection
{
    private array $releases = [];

    public function add(Release $release): void
    {
        $this->releases[] = $release;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->releases as $release) {
            $result[] = $release->toArray();
        }

        return $result;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
