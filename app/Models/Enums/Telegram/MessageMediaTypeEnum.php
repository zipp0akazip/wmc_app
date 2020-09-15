<?php

namespace App\Models\Enums\Telegram;

use App\Models\Enums\BaseEnum;

class MessageMediaTypeEnum extends BaseEnum
{
    const DOCUMENT = 'messageMediaDocument';
    const PHOTO = 'messageMediaPhoto';
}
