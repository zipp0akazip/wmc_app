<?php

namespace App\Models\Parsers\Telegram;

class Track
{
    private ?string $artist;
    private ?string $title;

    public function setDataFromMessage(array $data): void
    {
        $this->artist = $data['performer'];
        $this->title = $data['title'];
    }

    public function toArray(): array
    {
        return [
            'artist' => $this->artist,
            'title' => $this->title,
        ];
    }
}
