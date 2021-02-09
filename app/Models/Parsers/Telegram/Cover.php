<?php

namespace App\Models\Parsers\Telegram;

class Cover
{
    const ARTISTS_AND_TRACK_NAME_DELIMITER = '/[—|–|-]+/';

    private int $originalId;
    private string $originalName;
    private ArtistsCollection $artists;
    private string $name;
    private string $label = '';
    private string $date;
    private StylesCollection $styles;

    public function __construct()
    {
        $this->artists = new ArtistsCollection();
        $this->styles = new StylesCollection();
    }

    public function setDataFromMessage(array $message): void
    {
        $textMessage = $message['message'];

        $this->originalId = $message['id'];

        $messageLower = strtolower($textMessage);
        $parts = explode(PHP_EOL, $textMessage);
        $partsLower = explode(PHP_EOL, $messageLower);

        $handledParts = [];
        foreach ($partsLower as $stringNumber => $stringLower) {
            if (strpos($stringLower, 'label') !== false) {
                $label = explode('#', $parts[$stringNumber])[1];
                $this->label = trim($label);
                $handledParts[] = $stringNumber;
            }

            if (strpos($stringLower, 'date') !== false || strpos($stringLower, 'released') !== false) {
                $this->date = trim(explode(':', $parts[$stringNumber])[1]);
                $handledParts[] = $stringNumber;
            }

            if (strpos($stringLower, 'style') !== false) {
                $this->styles->fillByString($parts[$stringNumber]);

                $handledParts[] = $stringNumber;
            }
        }

        $remainingParts = array_diff_key($parts, array_flip($handledParts));
        $this->originalName = array_shift($remainingParts);
        $this->executeArtistsAndName();
    }

    public function getStylesCollection(): StylesCollection
    {
        return $this->styles;
    }

    public function getArtistsCollection(): ArtistsCollection
    {
        return $this->artists;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function toArray(): array
    {
        return [
            'original_id' => $this->originalId,
            'original_name' => $this->originalName,
            'artists' => $this->artists->toArray(),
            'name' => $this->name,
            'label' => $this->label,
            'date' => $this->date,
            'styles' => $this->styles->toArray(),
        ];
    }

    private function executeArtistsAndName(): void
    {
        list($artists, $name) = preg_split(self::ARTISTS_AND_TRACK_NAME_DELIMITER, $this->originalName);

        $this->artists->executeArtists($artists);
        $this->artists->executeArtistsFromTrackName($name);

        $this->name = trim($name);
    }
}
