<?php

namespace App\Console\Commands;

use App\Models\Enums\RoleEnum;
use Illuminate\Console\Command;

class RolePermissionFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role_permission:fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all roles and permission mapping';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $roles = RoleEnum::asArray();
    }
}
