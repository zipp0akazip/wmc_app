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
            'limit' => 100,
            'max_id' => 0,
            'min_id' => 0,
        ];

        $data = $madelineProto->messages->getHistory($settings);
//        $data = json_decode('{"_":"messages.channelMessages","inexact":false,"pts":18150,"count":14991,"messages":[{"_":"message","out":false,"mentioned":false,"media_unread":false,"silent":false,"post":true,"from_scheduled":false,"legacy":false,"edit_hide":false,"id":15180,"to_id":{"_":"peerChannel","channel_id":1164954106},"date":1599909769,"message":"","media":{"_":"messageMediaDocument","document":{"_":"document","id":5393501071391852589,"access_hash":9083779078260876518,"file_reference":{"_":"bytes","bytes":"AkVvyfoAADtMX1\/UX\/5q+3AOrWSFIKiXEXtT4cQ="},"date":1599813884,"mime_type":"audio\/mpeg","size":11098647,"thumbs":[{"_":"photoStrippedSize","type":"i","bytes":{"_":"bytes","bytes":"ASgojkIlCqnJ\/lT4rcEcqS3pUlqqomXXIYZqQswDbMDntUuWo7DREB8pVc98DOKieBXPC7T6jpUw4Xg4NKFJzweKnmGolB0KMVPairMybojwdw5+lFWmTYehBRccfQVMZIyOcBjyOOtQW22SE5fDDjFPGCwU9B0JNQ+xaEbBJ296UytHH8pzjrTiu05xge9IUTdtjGAOpz3oQMZn5Sc9R3oqKZyispGCeKKqK7kt9iujlGyKsrOh68H3ooptXEnYlaVNgBZTjpg0xrlEJK8nHaiiiwXKru0jFmOSaKKKYH8="}},{"_":"photoSize","type":"m","location":{"_":"fileLocationToBeDeprecated","volume_id":200113200304,"local_id":324},"w":320,"h":320,"size":52202}],"dc_id":2,"attributes":[{"_":"documentAttributeAudio","voice":false,"duration":272,"title":"Long Distance","performer":"Thematic"},{"_":"documentAttributeFilename","file_name":"04 - Thematic - Long Distance.mp3"}]}},"views":258},{"_":"message","out":false,"mentioned":false,"media_unread":false,"silent":false,"post":true,"from_scheduled":false,"legacy":false,"edit_hide":false,"id":15179,"to_id":{"_":"peerChannel","channel_id":1164954106},"date":1599909769,"message":"","media":{"_":"messageMediaDocument","document":{"_":"document","id":5393501071391852588,"access_hash":-863523257440537387,"file_reference":{"_":"bytes","bytes":"AkVvyfoAADtLX1\/UX7a4v86kD5NOrVBAvPYcsVQ="},"date":1599813869,"mime_type":"audio\/mpeg","size":11098637,"thumbs":[{"_":"photoStrippedSize","type":"i","bytes":{"_":"bytes","bytes":"ASgojkIlCqnJ\/lT4rcEcqS3pUlqqomXXIYZqQswDbMDntUuWo7DREB8pVc98DOKieBXPC7T6jpUw4Xg4NKFJzweKnmGolB0KMVPairMybojwdw5+lFWmTYehBRccfQVMZIyOcBjyOOtQW22SE5fDDjFPGCwU9B0JNQ+xaEbBJ296UytHH8pzjrTiu05xge9IUTdtjGAOpz3oQMZn5Sc9R3oqKZyispGCeKKqK7kt9iujlGyKsrOh68H3ooptXEnYlaVNgBZTjpg0xrlEJK8nHaiiiwXKru0jFmOSaKKKYH8="}},{"_":"photoSize","type":"m","location":{"_":"fileLocationToBeDeprecated","volume_id":200113200304,"local_id":324},"w":320,"h":320,"size":52202}],"dc_id":2,"attributes":[{"_":"documentAttributeAudio","voice":false,"duration":272,"title":"Mutation","performer":"Thematic"},{"_":"documentAttributeFilename","file_name":"03 - Thematic - Mutation.mp3"}]}},"views":259},{"_":"message","out":false,"mentioned":false,"media_unread":false,"silent":false,"post":true,"from_scheduled":false,"legacy":false,"edit_hide":false,"id":15178,"to_id":{"_":"peerChannel","channel_id":1164954106},"date":1599909769,"message":"","media":{"_":"messageMediaDocument","document":{"_":"document","id":5393501071391852587,"access_hash":-7930185099514223650,"file_reference":{"_":"bytes","bytes":"AkVvyfoAADtKX1\/UX2cWd9681D4nyHC8DR50XOg="},"date":1599813854,"mime_type":"audio\/mpeg","size":10458120,"thumbs":[{"_":"photoStrippedSize","type":"i","bytes":{"_":"bytes","bytes":"ASgojkIlCqnJ\/lT4rcEcqS3pUlqqomXXIYZqQswDbMDntUuWo7DREB8pVc98DOKieBXPC7T6jpUw4Xg4NKFJzweKnmGolB0KMVPairMybojwdw5+lFWmTYehBRccfQVMZIyOcBjyOOtQW22SE5fDDjFPGCwU9B0JNQ+xaEbBJ296UytHH8pzjrTiu05xge9IUTdtjGAOpz3oQMZn5Sc9R3oqKZyispGCeKKqK7kt9iujlGyKsrOh68H3ooptXEnYlaVNgBZTjpg0xrlEJK8nHaiiiwXKru0jFmOSaKKKYH8="}},{"_":"photoSize","type":"m","location":{"_":"fileLocationToBeDeprecated","volume_id":200113200304,"local_id":324},"w":320,"h":320,"size":52202}],"dc_id":2,"attributes":[{"_":"documentAttributeAudio","voice":false,"duration":256,"title":"Cloud Cover","performer":"Thematic"},{"_":"documentAttributeFilename","file_name":"02 - Thematic - Cloud Cover.mp3"}]}},"views":257},{"_":"message","out":false,"mentioned":false,"media_unread":false,"silent":false,"post":true,"from_scheduled":false,"legacy":false,"edit_hide":false,"id":15177,"to_id":{"_":"peerChannel","channel_id":1164954106},"date":1599909769,"message":"","media":{"_":"messageMediaDocument","document":{"_":"document","id":5393501071391852586,"access_hash":3228423982813172172,"file_reference":{"_":"bytes","bytes":"AkVvyfoAADtJX1\/UXw2TtX2SPWpBwtM+IXUYbRk="},"date":1599813844,"mime_type":"audio\/mpeg","size":10378702,"thumbs":[{"_":"photoStrippedSize","type":"i","bytes":{"_":"bytes","bytes":"ASgojkIlCqnJ\/lT4rcEcqS3pUlqqomXXIYZqQswDbMDntUuWo7DREB8pVc98DOKieBXPC7T6jpUw4Xg4NKFJzweKnmGolB0KMVPairMybojwdw5+lFWmTYehBRccfQVMZIyOcBjyOOtQW22SE5fDDjFPGCwU9B0JNQ+xaEbBJ296UytHH8pzjrTiu05xge9IUTdtjGAOpz3oQMZn5Sc9R3oqKZyispGCeKKqK7kt9iujlGyKsrOh68H3ooptXEnYlaVNgBZTjpg0xrlEJK8nHaiiiwXKru0jFmOSaKKKYH8="}},{"_":"photoSize","type":"m","location":{"_":"fileLocationToBeDeprecated","volume_id":200113200304,"local_id":324},"w":320,"h":320,"size":52202}],"dc_id":2,"attributes":[{"_":"documentAttributeAudio","voice":false,"duration":254,"title":"Squabble","performer":"Thematic"},{"_":"documentAttributeFilename","file_name":"01 - Thematic - Squabble.mp3"}]}},"views":261},{"_":"message","out":false,"mentioned":false,"media_unread":false,"silent":false,"post":true,"from_scheduled":false,"legacy":false,"edit_hide":false,"id":15176,"to_id":{"_":"peerChannel","channel_id":1164954106},"date":1599909768,"message":"Thematic - Squabble EP\nLabel: #Sofa\nRelease Date: 11.09.20\nStyle: #Deep\n @Drum_and_Bass_music","media":{"_":"messageMediaPhoto","photo":{"_":"photo","has_stickers":false,"id":5397846376160800717,"access_hash":3577209119008350523,"file_reference":{"_":"bytes","bytes":"AkVvyfoAADtIX1\/UX22u2eO9pLgm0BaMuf6blDA="},"date":1599909767,"sizes":[{"_":"photoStrippedSize","type":"i","bytes":{"_":"bytes","bytes":"ASgoZIRKFVASf5U+K3BXlSW9KfaoqJlxw3WpCzANs9e1S5DsNWIDgqufYdKjeAMeF2n9KlH3ODgmnBepweKnmHyme6FGINFWpkDQtxlhz9KK0TJsPQgouOOnQVKXjPXAY8jjrUFvtkh5fDDtinjG4Keg75rNloDjJx3oMzRx\/Kcgdacy7TnGPrQUXdtiGAOvPehA2Rn7pOeo70VHO5RCCME8UVUYsltFdHKNkVYWdD14NFFNq4J2JTKhQAsDjpg0xrhEJK8nGMCiiiwr2bKsjtI5ZzkmiiimIw=="}},{"_":"photoSize","type":"m","location":{"_":"fileLocationToBeDeprecated","volume_id":200107300484,"local_id":55221},"w":320,"h":320,"size":59080},{"_":"photoSize","type":"x","location":{"_":"fileLocationToBeDeprecated","volume_id":200107300484,"local_id":55222},"w":800,"h":800,"size":300461},{"_":"photoSize","type":"y","location":{"_":"fileLocationToBeDeprecated","volume_id":200107300484,"local_id":55219},"w":1000,"h":1000,"size":331078}],"dc_id":2}},"entities":[{"_":"messageEntityHashtag","offset":30,"length":5},{"_":"messageEntityHashtag","offset":66,"length":5},{"_":"messageEntityMention","offset":73,"length":20}],"views":255,"edit_date":1599910054}],"chats":[{"_":"channel","creator":false,"left":false,"broadcast":true,"verified":false,"megagroup":false,"restricted":false,"signatures":false,"min":false,"scam":false,"has_link":false,"has_geo":false,"slowmode_enabled":false,"id":1164954106,"access_hash":5543061225889300289,"title":"Drum and Bass","username":"Drum_and_Bass_music","photo":{"_":"chatPhoto","photo_small":{"_":"fileLocationToBeDeprecated","volume_id":239519462,"local_id":29100},"photo_big":{"_":"fileLocationToBeDeprecated","volume_id":239519462,"local_id":29102},"dc_id":2},"date":1577047656,"version":0}],"users":[]}', true);

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
