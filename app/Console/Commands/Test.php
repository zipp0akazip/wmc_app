<?php

namespace App\Console\Commands;

use App\Models\StylesModel;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'For tests';

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
        $nodes = StylesModel::withDepth()->get()->toTree();
//        $nodes = StylesModel::withDepth()->where('name', 'ilike', '%' . 'drum' . '%')->get()->toTree();

        $this->dumpNode($nodes);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection | \Kalnoy\Nestedset\Collection $nodes
     */
    private function dumpNode($nodes)
    {
        foreach ($nodes as $n => $node) {
        var_dump(get_class($nodes));
            $string = str_repeat('|   ', $node->depth) . '|-- ' . $node->name;

            $this->info($string);

            if (count($node->children) > 0) {
                $this->dumpNode($node->children);
            }
        }
    }
}
