<?php

namespace App\Console\Commands;

use danog\MadelineProto\Logger;
use Illuminate\Console\Command;

class ParseTG extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:tg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    private static $api_id = '1569255';

    private static $api_hash = '14d6534a95313783d708cf2b678744ac';
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $MadelineProto = new \danog\MadelineProto\API('session.madeline',     [
            'logger' => [
                'logger' => Logger::NO_LOGGER
            ]
        ]);

        $settings = array(
            'peer' => '@Drum_and_Bass_music', //название_канала, должно начинаться с @, например @breakingmash
            'offset_id' => 0,
            'offset_date' => 0,
            'add_offset' => 0,
            'limit' => 5, //Количество постов, которые вернет клиент
            'max_id' => 0, //Максимальный id поста
            'min_id' => 0, //Минимальный id поста - использую для пагинации, при  0 возвращаются последние посты.
        );


        $data = $MadelineProto->messages->getHistory($settings);

        var_dump($data['messages']); exit;


//        set_time_limit(120);
//
//        $settings = [
//            'authorization' => [
//                'default_temp_auth_key_expires_in' => 900000, // секунды. Столько будут действовать ключи
//            ],
//            'app_info' => [// Эти данные мы получили после регистрации приложения на https://my.telegram.org
//                'api_id' => self::$api_id,
//                'api_hash' => self::$api_hash
//            ],
//            'logger' => [// Вывод сообщений и ошибок
//                'logger' => 3, // выводим сообещения через echo
//                'logger_level' => \danog\MadelineProto\Logger::ULTRA_VERBOSE,
//            ],
//            'max_tries' => [// Количество попыток установить соединения на различных этапах работы.
//                'query' => 5,
//                'authorization' => 5,
//                'response' => 5,
//            ],
//            'updates' => [//
//                'handle_updates' => false,
//                'handle_old_updates' => false,
//            ],
//        ];
//
//        try {
//
//            $MadelineProto = new \danog\MadelineProto\API('session.madeline', $settings);
//
//            $MadelineProto->phone_login(\readline('Enter your phone number: ')); //вводим в консоли свой номер телефона
//
//            $authorization = $MadelineProto->complete_phone_login(\readline('Enter the code you received: ')); // вводим в консоли код авторизации, который придет в телеграм
//
//            if ($authorization['_'] === 'account.noPassword') {
//
//                throw new \danog\MadelineProto\Exception('2FA is enabled but no password is set!');
//            }
//            if ($authorization['_'] === 'account.password') {
//                $authorization = $MadelineProto->complete_2fa_login(\readline('Please enter your password (hint ' . $authorization['hint'] . '): ')); //если включена двухфакторная авторизация, то вводим в консоли пароль.
//            }
//            if ($authorization['_'] === 'account.needSignup') {
//                $authorization = $MadelineProto->complete_signup(\readline('Please enter your first name: '), \readline('Please enter your last name (can be empty): '));
//            }
//        } catch (Exception $ex) {
//            echo $ex->getMessage();
//            exit();
//        }
//        $MadelineProto->session = 'session.madeline';
//
//        $MadelineProto->serialize(); // Сохраняем настройки сессии в файл, что бы использовать их для быстрого подключения.
    }
}
