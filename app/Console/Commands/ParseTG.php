<?php

namespace App\Console\Commands;

use App\Sources\Telegram;
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
    private Telegram $source;

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

        $this->source = $telegram;
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
            $this->source->getHistory();
        }
    }

    /**
     * @throws \danog\MadelineProto\Exception
     */
    private function createSession(): void
    {
        $this->source->createSessionFile();
    }
}
