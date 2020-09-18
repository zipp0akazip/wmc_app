<?php

namespace App\Models\Parsers\Telegram;

class Cover
{
    private ?int $
    private ?string $artist;
    private ?string $name;
    private ?string $label;
    private ?string $date;
    private ?array $styles;

    public function setDataFromMessage(string $message): void
    {
        $messageLower = strtolower($message);

        $parts = explode(PHP_EOL, $message);
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
                $styles = str_ireplace(['style:', 'style'], '', $parts[$stringNumber]);
                $styles = trim($styles);
                $styles = explode('#', $styles);
                $styles = array_map('trim', $styles);
                $styles = array_filter($styles, fn($value) => !is_null($value) && $value !== '');

                $this->styles = $styles;
                $handledParts[] = $stringNumber;
            }
        }

        $remainingParts = array_diff_key($parts, array_flip($handledParts));
        list($artist, $name) = preg_split('/[вЂ“|-]+/', array_shift($remainingParts));

        $this->artist = trim($artist);
        $this->name = trim($name);
    }

    public function toArray(): array
    {
        return [
            'artist' => $this->artist,
            'name' => $this->name,
            'label' => $this->label,
            'date' => $this->date,
            'styles' => $this->styles,
        ];
    }
}
