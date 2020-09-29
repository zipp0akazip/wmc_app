<?php

namespace App\Sources;

use App\Models\Enums\RawReleasesStatusEnum;
use App\Models\RawReleasesModel;
use danog\MadelineProto\API;
use danog\MadelineProto\Logger;
use danog\MadelineProto\Exception as MadelineProtoException;
use App\Parsers\Telegram as TelegramParser;

final class Telegram
{
    const CHANNEL_NAME = '@Drum_and_Bass_music';

    private string $apiId;

    private string $apiHash;

    private string $sessionFilePath;

    private TelegramParser $parser;

    public function __construct(TelegramParser $parser)
    {
        $this->apiId = config('services.telegram.id');
        $this->apiHash = config('services.telegram.hash');
        $this->sessionFilePath = storage_path('telegram_session/session.madeline');

        $this->parser = $parser;
    }

    public function handleHistory(): void
    {
        $madelineProto = new API($this->sessionFilePath, $this->getConnectionSettings());

        $settings = [
            'peer' => self::CHANNEL_NAME,
            'offset_id' => 0,
            'offset_date' => 0,
            'add_offset' => 0,
            'limit' => 19,
            'max_id' => 0,
            'min_id' => 0,
        ];

        $data = $madelineProto->messages->getHistory($settings);
        $messages = array_reverse($data['messages']);

        $releases = $this->parser->handleRawMessages($messages);

        foreach ($releases->getAll() as $release) {
            $releaseModel = new RawReleasesModel([
                'data' => $release,
                'status' => RawReleasesStatusEnum::NEW,
            ]);
            $releaseModel->save();
        }
    }

    public function createSessionFile(): void
    {
        set_time_limit(120);

        try {
            $madelineProto = new API('session.madeline', $this->getConnectionSettings());

            $madelineProto->phone_login(\readline('Enter your phone number: ')); //вводим в консоли свой номер телефона

            $authorization = $madelineProto->complete_phone_login(\readline('Enter the code you received: ')); // вводим в консоли код авторизации, который придет в телеграм

            if ($authorization['_'] === 'account.noPassword') {

                throw new MadelineProtoException('2FA is enabled but no password is set!');
            }
            if ($authorization['_'] === 'account.password') {
                $authorization = $madelineProto->complete_2fa_login(\readline('Please enter your password (hint ' . $authorization['hint'] . '): ')); //если включена двухфакторная авторизация, то вводим в консоли пароль.
            }
            if ($authorization['_'] === 'account.needSignup') {
                $authorization = $madelineProto->complete_signup(\readline('Please enter your first name: '), \readline('Please enter your last name (can be empty): '));
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        $madelineProto->session = $this->sessionFilePath;

        $madelineProto->serialize(); // Сохраняем настройки сессии в файл, что бы использовать их для быстрого подключения.

        echo 'Session file save to: ' . $this->sessionFilePath . PHP_EOL;
    }

    private function getConnectionSettings(): array
    {
        return [
            'authorization' => [
                'default_temp_auth_key_expires_in' => 900000, // секунды. Столько будут действовать ключи
            ],
            'app_info' => [// Эти данные мы получили после регистрации приложения на https://my.telegram.org
                'api_id' => $this->apiId,
                'api_hash' => $this->apiHash
            ],
            'logger' => [// Вывод сообщений и ошибок
                'logger' => Logger::NO_LOGGER, // выводим сообещения через echo
                'logger_level' => Logger::FATAL_ERROR,
            ],
            'max_tries' => [// Количество попыток установить соединения на различных этапах работы.
                'query' => 5,
                'authorization' => 5,
                'response' => 5,
            ],
            'updates' => [//
                'handle_updates' => false,
                'handle_old_updates' => false,
            ],
        ];
    }

}
