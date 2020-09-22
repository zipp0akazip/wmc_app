<?php

namespace App\Models\Parsers\Telegram;

class Cover
{
    private ?int $originalId;
    private ?string $artist;
    private ?string $name;
    private ?string $label;
    private ?string $date;
    private StylesCollection $styles;

    public function __construct()
    {
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
                $this->label = explode('#', $parts[$stringNumber])[1];
                $handledParts[] = $stringNumber;
            }

            if (strpos($stringLower, 'date') !== false) {
                $this->date = trim(explode(':', $parts[$stringNumber])[1]);
                $handledParts[] = $stringNumber;
            }

            if (strpos($stringLower, 'style') !== false) {
                $this->styles->fillByString($parts[$stringNumber]);

                $handledParts[] = $stringNumber;
            }
        }

        $remainingParts = array_diff_key($parts, array_flip($handledParts));
        list($artist, $name) = preg_split('/[—|–|-]+/', array_shift($remainingParts));

        $this->artist = trim($artist);
        $this->name = trim($name);
    }

    public function getStylesCollection(): StylesCollection
    {
        return $this->styles;
    }

    public function toArray(): array
    {
        return [
            'original_id' => $this->originalId,
            'artist' => $this->artist,
            'name' => $this->name,
            'label' => $this->label,
            'date' => $this->date,
            'styles' => $this->styles,
        ];
    }
}
