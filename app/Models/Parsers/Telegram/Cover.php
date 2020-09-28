<?php

namespace App\Models\Parsers\Telegram;

class Cover
{
    private ?int $originalId;
    private ArtistsCollection $artists;
    private ?string $name;
    private ?string $label;
    private ?string $date;
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
        $this->executeArtistsAndName(array_shift($remainingParts));

        var_dump($this);exit;
    }

    public function getStylesCollection(): StylesCollection
    {
        return $this->styles;
    }

    public function toArray(): array
    {
        return [
            'original_id' => $this->originalId,
            'artist' => $this->artists,
            'name' => $this->name,
            'label' => $this->label,
            'date' => $this->date,
            'styles' => $this->styles,
        ];
    }

    private function executeArtistsAndName(string $str): void
    {
        list($artists, $name) = preg_split('/[—|–|-]+/', $str);

        $artists = preg_split('/(and|vs|&|feat)+/', $artists);
        $artists = array_map('trim', $artists);

        foreach ($artists as $position => $artist) {
            $artistModel = resolve(Artist::class);
            $artistModel->setName($artist);
            $artistModel->setPosition($this->artists->getNextPosition());

            $this->artists->add($artistModel);
        }

        preg_match_all('/\([\w\s]+\)/', $name, $matches, PREG_PATTERN_ORDER);

        foreach ($matches[0] as $match) {
            $artist = $this->clearArtistName($match);
            $artistModel = resolve(Artist::class);
            $artistModel->setName($artist);
            $artistModel->setPosition($this->artists->getNextPosition());

            $this->artists->add($artistModel);

            $name = str_replace($match, '', $name);
        }

        $this->name = trim($name);
    }

    private function clearArtistName(string $name): string
    {
        return trim(str_replace(['(', ')', 'remix', 'Remix', 'feat', '.'], '', $name));
    }
}
