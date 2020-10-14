<?php

namespace App\Console\Commands;

use App\Tournament;
use Illuminate\Console\Command;

class ParseLegueDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'league:parse';

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
        $leagues = Tournament::where('active', 1)->get();
        foreach ($leagues as $league) {
            switch ($league->site_id){
                case 4:
                    $json = file_get_contents('https://out.sportarena.com/api/v1/tournaments/'.$league->uniq_id.'/table');
                    $league->data = $json;
                    $league->save();

                    break;
            }
        }

        return 0;
    }
}
