<?php

use App\Components\Logs\TwoChannelsLogger;
use Monolog\Logger;

class LoggerChannels  {
    const PARSER_TG = 'parser:tg';
}

return [
    'default' => env('LOG_CHANNEL', 'stack'),

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],
        LoggerChannels::PARSER_TG => [
            'driver' => 'custom',
            'via' => TwoChannelsLogger::class,
            'name' => LoggerChannels::PARSER_TG,
            'level' => Logger::DEBUG,
            'path' => 'parsers/tg.log',
        ],
    ],

];
