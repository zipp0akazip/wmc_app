<?php

namespace App\Models\Enums\Telegram;

use App\Models\Enums\BaseEnum;

class MessageTypeEnum extends BaseEnum
{
    const NONE = 'none';
    const TRACK = 'track';
    const COVER = 'cover';
    const VIDEO= 'video';
}
