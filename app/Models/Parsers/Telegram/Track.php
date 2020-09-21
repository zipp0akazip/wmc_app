<?php

namespace App\Models\Parsers\Telegram;

class Track
{
    private ?int $originalId;
    private ?string $artist;
    private ?string $title;

    public function setDataFromMessage(array $message, int $attributeNumber): void
    {
        $this->originalId = $message['id'];

        $data = $message['media']['document']['attributes'][$attributeNumber];
        $this->artist = $data['performer'];
        $this->title = $data['title'];
    }

    public function toArray(): array
    {
        return [
            'original_id' => $this->originalId,
            'artist' => $this->artist,
            'title' => $this->title,
        ];
    }
}
