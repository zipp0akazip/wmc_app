<?php

namespace App\Services;

use danog\MadelineProto\API;
use danog\MadelineProto\Logger;
use danog\MadelineProto\Exception as MadelineProtoException;

final class Telegram
{
    const INDEX_TYPE_DOCUMENT = 'messageMediaDocument';
    const INDEX_TYPE_PHOTO = 'messageMediaPhoto';

    const DOCUMENT_ATTRIBUTE_TYPE_AUDIO = 'documentAttributeAudio';

    const MIME_TYPE_AUDIO = 'audio/mpeg';

    const MESSAGE_TYPE_NONE = 'none';
    const MESSAGE_TYPE_TRACK = 'track';
    const MESSAGE_TYPE_COVER = 'cover';

    private string $apiId;

    private string $apiHash;

    private string $sessionFilePath;

    public function __construct()
    {
        $this->apiId = config('services.telegram.id');
        $this->apiHash = config('services.telegram.hash');
        $this->sessionFilePath = storage_path('telegram_session/session.madeline');
    }

    public function getHistory(): array
    {
        $MadelineProto = new API($this->sessionFilePath, $this->getConnectionSettings());

        $settings = [
            'peer' => '@Drum_and_Bass_music',
            'offset_id' => 0,
            'offset_date' => 0,
            'add_offset' => 0,
            'limit' => 5,
            'max_id' => 0,
            'min_id' => 0,
        ];

        $data = $MadelineProto->messages->getHistory($settings);

        $messages = array_reverse($data['messages']);
//        $messages = $data['messages'];

        foreach ($messages as $message) {
            $ype = $this->getMessageType($message);

            var_dump($ype);
//            if ($this->isMusic($message)) {
//                var_dump('track');
//            } else {
//                var_dump($message, 'NOT MUSIC');exit;
//            }

        }

//        var_dump($data);
        exit;
    }

    public function createSessionFile(): void
    {
        set_time_limit(120);

        try {
            $MadelineProto = new API('session.madeline', $this->getConnectionSettings());

            $MadelineProto->phone_login(\readline('Enter your phone number: ')); //вводим в консоли свой номер телефона

            $authorization = $MadelineProto->complete_phone_login(\readline('Enter the code you received: ')); // вводим в консоли код авторизации, который придет в телеграм

            if ($authorization['_'] === 'account.noPassword') {

                throw new MadelineProtoException('2FA is enabled but no password is set!');
            }
            if ($authorization['_'] === 'account.password') {
                $authorization = $MadelineProto->complete_2fa_login(\readline('Please enter your password (hint ' . $authorization['hint'] . '): ')); //если включена двухфакторная авторизация, то вводим в консоли пароль.
            }
            if ($authorization['_'] === 'account.needSignup') {
                $authorization = $MadelineProto->complete_signup(\readline('Please enter your first name: '), \readline('Please enter your last name (can be empty): '));
            }
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            exit();
        }
        $MadelineProto->session = $this->sessionFilePath;

        $MadelineProto->serialize(); // Сохраняем настройки сессии в файл, что бы использовать их для быстрого подключения.

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

    private function getMessageType(array $message): string
    {
        $type = self::MESSAGE_TYPE_NONE;

        if ($this->isPhoto($message)) {
            $type = self::MESSAGE_TYPE_COVER;
        } elseif ($this->isTrack($message)) {
            $type = self::MESSAGE_TYPE_TRACK;
        }

        return $type;
    }

    private function isPhoto(array $message): bool
    {
        return $message['media']['_'] === self::INDEX_TYPE_PHOTO;
    }

    private function isTrack(array $message): bool
    {
        $result = false;

        if ($message['media']['_'] === self::INDEX_TYPE_DOCUMENT) {
            $isDocumentAttributeAudio = false;
            foreach ($message['media']['document']['attributes'] as $attribute) {
                if ($attribute['_'] === self::DOCUMENT_ATTRIBUTE_TYPE_AUDIO) {
                    $isDocumentAttributeAudio = true;
                    break;
                }
            }

            $result = $message['media']['document']['mime_type'] === self::MIME_TYPE_AUDIO && $isDocumentAttributeAudio;
        }

        return $result;
    }
}
