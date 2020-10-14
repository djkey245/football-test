<?php

namespace App\Console\Commands;

use App\LiveResult;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ParseLiveResultCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'live-result:parse';

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
        $date = Carbon::now()->format('Y/m/d');
        $json = file_get_contents('https://out.sportarena.com/api/v1/livescore/'.$date);
        if(!empty(json_decode($json)->sports[0]->tournaments)){

            $result = json_decode($json)->sports[0]->tournaments;
            $isset = LiveResult::whereDate('created_at',Carbon::now())->first();
            if(!empty($isset)){
                $isset->json = json_encode($result);
                $isset->update();
            }
            else {
                $live_result = new LiveResult();
                $live_result->json = json_encode($result);
                $live_result->save();
            }
        }
    }
}
