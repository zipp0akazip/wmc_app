<?php

namespace App\Console\Commands;

use App\Services\Telegram;
use danog\MadelineProto\Logger;
use Illuminate\Console\Command;

class ParseTG extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:tg {--create-session}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Telegram parser';

    /**
     * @var Telegram
     */
    private Telegram $telegramService;

    /**
     * Create a new command instance.
     *
     * @param Telegram $telegram
     *
     * @return void
     */
    public function __construct(Telegram $telegram)
    {
        parent::__construct();

        $this->telegramService = $telegram;
    }

    /**
     * Execute the console command.
     *
     * @throws \danog\MadelineProto\Exception
     */
    public function handle()
    {
        if ($this->option('create-session')) {
            $this->createSession();
        } else {
            $this->telegramService->getHistory();
        }
    }

    /**
     * @throws \danog\MadelineProto\Exception
     */
    private function createSession(): void
    {
        $this->telegramService->createSessionFile();
    }
}
