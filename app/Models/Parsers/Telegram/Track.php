<?php

namespace App\Models\Parsers\Telegram;

class Track
{
    private int $originalId;
    private string $originalName;
    private ArtistsCollection $artists;
    private string $title;

    public function __construct()
    {
        $this->artists = new ArtistsCollection();
    }

    public function setDataFromMessage(array $message, int $attributeNumber): void
    {
        $data = $message['media']['document']['attributes'][$attributeNumber];

        $this->originalId = $message['id'];
        $this->originalName = $data['performer'] . ' - ' . $data['title'];
        $this->title = $data['title'];

        $this->artists->executeArtists($data['performer']);
        $this->artists->executeArtistsFromTrackName($data['title']);
    }

    public function toArray(): array
    {
        return [
            'original_id' => $this->originalId,
            'artists' => $this->artists->toArray(),
            'title' => $this->title,
        ];
    }
}
