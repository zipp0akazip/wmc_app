<?php

namespace App\Components\Logs;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class TwoChannelsLogger
{
    public function __invoke(array $config)
    {
        $logger = new Logger($config['name']);

        // console handler
        $handler = new StreamHandler('php://stderr');
        if (isset($config['level'])) {
            $handler->setLevel($config['level']);
        }
        $handler->setFormatter(new ConsoleFormatter());
        $logger->pushHandler($handler);

        //file handler
        if (isset($config['path'])) {
            $path = storage_path('logs/' . $config['path']);
        } else {
            $path = storage_path('logs/' . $config['name'] . '.log');
        }

        $handler = new RotatingFileHandler($path);
        if (isset($config['level'])) {
            $handler->setLevel($config['level']);
        }
        $handler->setFormatter(new LineFormatter());
        $logger->pushHandler($handler);

        return $logger;
    }
}
