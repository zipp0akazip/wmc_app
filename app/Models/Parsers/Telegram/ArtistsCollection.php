<?php

namespace App\Models\Parsers\Telegram;

class ArtistsCollection
{
    const ARTISTS_DELIMITER = '/(and|vs|&|feat\.|feat)+/i';
    const ARTISTS_IN_TRACK_NAME_PATTERN = '/\([\w\s]+\)/i';
    const CLEAR_ARTIST_NAME_FROM_TRACK_NAME_PATTERN = ['(', ')', 'remix', 'feat', '.'];
    const REMIXER_MARKERS = ['remix', 'rmx', 'remixed'];

    private array $artists = [];

    public function executeArtists(string $artists): void
    {
        $artists = preg_split(self::ARTISTS_DELIMITER, $artists);
        $artists = array_map('trim', $artists);

        foreach ($artists as $position => $artist) {
            $artistModel = new Artist();
            $artistModel->setName($artist);
            $artistModel->setPosition($this->getNextPosition());

            $this->add($artistModel);
        }
    }

    public function executeArtistsFromTrackName(string &$name): void
    {
        preg_match_all(self::ARTISTS_IN_TRACK_NAME_PATTERN, $name, $matches, PREG_PATTERN_ORDER);

        foreach ($matches[0] as $match) {
            $artist = $this->clearArtistName($match);
            $artistModel = new Artist();
            $artistModel->setName($artist);
            $artistModel->setPosition($this->getNextPosition());

            if ($this->isRemixer($match)) {
                $artistModel->setIsRemixer();
            }

            $this->add($artistModel);

            $name = str_replace($match, '', $name);
        }
    }

    public function add(Artist $artist): void
    {
        $this->artists[] = $artist;
    }

    public function getLastPosition(): int
    {
        $position = 0;

        foreach ($this->artists as $artist) {
            if ($position < $artist->getPosition()) {
                $position = $artist->getPosition();
            }
        }

        return $position;
    }

    public function getNextPosition(): int
    {
        return $this->getLastPosition() + 1;
    }

    public function toArray(): array
    {
        $result = [];

        foreach ($this->artists as $artist) {
            $result[] = $artist->toArray();
        }

        return $result;
    }

    private function clearArtistName(string $name): string
    {
        return trim(str_ireplace(self::CLEAR_ARTIST_NAME_FROM_TRACK_NAME_PATTERN, '', $name));
    }

    private function isRemixer(string $str): bool
    {
        $result = false;

        foreach (self::REMIXER_MARKERS as $marker) {
            if (stripos($str, $marker) !== false) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
