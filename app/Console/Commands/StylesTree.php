<?php

namespace App\Console\Commands;

use App\Models\StyleModel;
use Illuminate\Console\Command;

class StylesTree extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'styles:tree {--find=}';

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

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $find = $this->option('find');

        if ($find !== null && !empty($find)) {
            $nodes = StyleModel::withDepth()
                ->with('ancestors')
                ->where('name', 'ilike', '%' . $find . '%')
                ->get();

            foreach ($nodes as &$node) {
//                $node =
                var_dump(get_class($nodes));exit;
            }
//            $nodes->toTree();
var_dump($nodes->toArray());exit;

//            var_dump($nodes->toArray());
//            exit;
         } else {
            $nodes = StyleModel::withDepth()->get()->toTree();
        }

        $this->dumpNode($nodes);
    }


    /**
     * @param \Illuminate\Database\Eloquent\Collection | \Kalnoy\Nestedset\Collection $nodes
     */
    private function dumpNode($nodes)
    {
        foreach ($nodes as $n => $node) {
            $string = str_repeat('|   ', $node->depth) . '|-- ' . $node->name;

            $find = $this->option('find');
            if ($find !== null && !empty($find) && stripos($node->name, $find) !== false) {
                $this->error($string);
            } else {
                $this->info($string);
            }

            if (count($node->children) > 0) {
                $this->dumpNode($node->children);
            }
        }
    }
}
