<?php

namespace App\Parsers;

use App\Models\Enums\Telegram\DocumentAttributeTypeEnum;
use App\Models\Enums\Telegram\MessageMediaTypeEnum;
use App\Models\Enums\Telegram\MessageTypeEnum;
use App\Models\Enums\Telegram\MimeTypeEnum;
use App\Models\Parsers\Telegram\Release;
use App\Models\Parsers\Telegram\ReleasesCollection;
use App\Models\Parsers\Telegram\Track;
use danog\MadelineProto\Exception;
use Illuminate\Support\Facades\Log;

class Telegram
{
    private ReleasesCollection $releases;

    private ?Release $currentRelease = null;

    public function __construct(ReleasesCollection $releases)
    {
        $this->releases = $releases;
    }

    public function handleRawMessages(array $messages): ReleasesCollection
    {
        foreach ($messages as $rowNumber => $message) {
            switch ($this->getMessageType($message)) {
                case MessageTypeEnum::COVER:
                    if (!is_null($this->currentRelease)) {
                        $this->releases->add($this->currentRelease);
                        $this->currentRelease = null;
                    }
                    $this->handleCover($message);
                    break;
                case MessageTypeEnum::TRACK:
                    if ($this->currentRelease === null) {
                        continue 2;
                    }
                    $this->handleTrack($message);
                    break;
                case MessageTypeEnum::VIDEO:
                    if (!is_null($this->currentRelease)) {
                        $this->releases->add($this->currentRelease);
                        $this->currentRelease = null;
                    }
                    break;
                case MessageTypeEnum::NONE:
                    Log::channel('parser:tg')->warning('Can not receive message type.', [$message]);
                    break;
            }

            if (count($messages) - 1 === $rowNumber && $this->currentRelease !== null) {
                $this->releases->add($this->currentRelease);
            }
        }


        return $this->releases;
    }

    private function getMessageType(array $message): string
    {
        $type = MessageTypeEnum::NONE;

        if ($this->isCover($message)) {
            $type = MessageTypeEnum::COVER;
        } elseif ($this->isTrack($message)) {
            $type = MessageTypeEnum::TRACK;
        } elseif ($this->isVideo($message)) {
            $type = MessageTypeEnum::VIDEO;
        }

        return $type;
    }

    private function isCover(array $message): bool
    {
        return $message['media']['_'] === MessageMediaTypeEnum::PHOTO &&
            strpos($message['message'], 'Style');
    }

    private function isTrack(array $message): bool
    {
        return $message['media']['_'] === MessageMediaTypeEnum::DOCUMENT &&
            $message['media']['document']['mime_type'] === MimeTypeEnum::AUDIO;
    }

    private function isVideo(array $message): bool
    {
        return $message['media']['_'] === MessageMediaTypeEnum::DOCUMENT &&
            $message['media']['document']['mime_type'] === MimeTypeEnum::VIDEO;
    }

    private function handleCover(array $message): void
    {
        $this->currentRelease = new Release();

        $this->currentRelease->getCover()->setDataFromMessage($message);
    }

    private function handleTrack(array $message): void
    {
        foreach ($message['media']['document']['attributes'] as $attributeNumber => $attributeData) {
            if ($attributeData['_'] === DocumentAttributeTypeEnum::AUDIO) {
                $track = new Track();
                $track->setDataFromMessage($message, $attributeNumber);

                $this->currentRelease->getTracksCollection()->add($track);
            }
        }
    }

    private function isFirstMessageValid(array $messages): bool
    {
        $result = null;

        foreach ($messages as $message) {
            if ($this->isCover($message)) {
                $result = true;
                break;
            } elseif ($this->isVideo($message)) {
                continue;
            } else {
                $result = false;
                break;
            }
        }

        return $result;
    }
}
