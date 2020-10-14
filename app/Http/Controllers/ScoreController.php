<?php

namespace App\Http\Controllers;

use App\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ScoreController extends Controller
{


    public function league($league){
        $league = Tournament::where('link', $league)->first();
        if(!empty($league)){
            $json = file_get_contents('https://ua.tribuna.com/core/stat/gadget/tournament_table/?args={%22tournament_id%22:54}');
            dd(json_decode($json));
        }
        else{
            return Redirect::route('home');
        }

    }
}
