<?php

namespace App\Models\Parsers\Telegram;

class Release
{
    private Cover $cover;

    private TracksCollection $tracks;

    public function __construct()
    {
        $this->cover = new Cover();
        $this->tracks = new TracksCollection();
    }

    public function getCover(): Cover
    {
        return $this->cover;
    }

    public function getTracksCollection(): TracksCollection
    {
         return $this->tracks;
    }
}
